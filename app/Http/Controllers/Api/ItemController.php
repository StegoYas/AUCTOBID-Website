<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ItemController extends Controller
{
    /**
     * Get all categories
     */
    public function categories(): JsonResponse
    {
        $categories = Category::active()->get(['id', 'name', 'description', 'icon']);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get all conditions
     */
    public function conditions(): JsonResponse
    {
        $conditions = Condition::active()->get(['id', 'name', 'description', 'quality_rating']);

        return response()->json([
            'success' => true,
            'data' => $conditions,
        ]);
    }

    /**
     * Submit new item for auction
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'starting_price' => 'required|numeric|min:10000',
            'minimum_bid_increment' => 'nullable|numeric|min:1000',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Create item
        $item = Item::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'minimum_bid_increment' => $request->minimum_bid_increment ?? 10000,
            'status' => 'pending',
        ]);

        // Upload images
        if ($request->hasFile('images')) {
            $isFirst = true;
            $sortOrder = 0;

            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('items', 'public');
                
                // Create thumbnail
                $thumbnailPath = null;
                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read(Storage::disk('public')->path($path));
                    $image->cover(300, 300);
                    
                    $thumbnailName = 'thumbnails/' . pathinfo($path, PATHINFO_FILENAME) . '_thumb.jpg';
                    Storage::disk('public')->makeDirectory('thumbnails');
                    $image->save(Storage::disk('public')->path($thumbnailName), 80);
                    $thumbnailPath = $thumbnailName;
                } catch (\Exception $e) {
                    // Thumbnail creation failed, continue without it
                }

                ItemImage::create([
                    'item_id' => $item->id,
                    'image_path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                    'is_primary' => $isFirst,
                    'sort_order' => $sortOrder++,
                ]);

                $isFirst = false;
            }
        }

        $item->load(['images', 'category', 'condition']);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diajukan. Tunggu persetujuan admin.',
            'data' => $this->formatItem($item),
        ], 201);
    }

    /**
     * Get user's submitted items
     */
    public function myItems(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->query('status');

        $query = Item::with(['images', 'category', 'condition', 'auction'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $items = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $items->through(fn($item) => $this->formatItem($item)),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    /**
     * Get item detail
     */
    public function show(Item $item): JsonResponse
    {
        $item->load(['images', 'category', 'condition', 'user', 'auction.bids']);

        return response()->json([
            'success' => true,
            'data' => $this->formatItem($item, true),
        ]);
    }

    /**
     * Format item for response
     */
    private function formatItem(Item $item, bool $detailed = false): array
    {
        $data = [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'starting_price' => (float) $item->starting_price,
            'minimum_bid_increment' => (float) $item->minimum_bid_increment,
            'status' => $item->status,
            'rejection_reason' => $item->rejection_reason,
            'category' => $item->category ? [
                'id' => $item->category->id,
                'name' => $item->category->name,
            ] : null,
            'condition' => $item->condition ? [
                'id' => $item->condition->id,
                'name' => $item->condition->name,
                'quality_rating' => $item->condition->quality_rating,
            ] : null,
            'images' => $item->images->map(fn($img) => [
                'id' => $img->id,
                'url' => asset('storage/' . $img->image_path),
                'thumbnail_url' => $img->thumbnail_path ? asset('storage/' . $img->thumbnail_path) : asset('storage/' . $img->image_path),
                'is_primary' => $img->is_primary,
            ]),
            'primary_image' => $item->primaryImage ? asset('storage/' . $item->primaryImage->image_path) : null,
            'created_at' => $item->created_at->toIso8601String(),
        ];

        if ($detailed) {
            $data['owner'] = $item->user ? [
                'id' => $item->user->id,
                'name' => $item->user->name,
            ] : null;

            if ($item->auction) {
                $data['auction'] = [
                    'id' => $item->auction->id,
                    'status' => $item->auction->status,
                    'current_price' => (float) $item->auction->current_price,
                    'total_bids' => $item->auction->total_bids,
                    'start_time' => $item->auction->start_time->toIso8601String(),
                    'end_time' => $item->auction->end_time->toIso8601String(),
                    'winner_id' => $item->auction->winner_id,
                ];
            }
        }

        return $data;
    }
}
