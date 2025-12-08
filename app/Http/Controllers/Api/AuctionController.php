<?php

namespace App\Http\Controllers\Api;

use App\Events\NewBidEvent;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    /**
     * Get active auctions
     */
    public function index(Request $request): JsonResponse
    {
        $query = Auction::with(['item.images', 'item.category'])
            ->where('status', 'active')
            ->where('end_time', '>', now())
            ->orderBy('end_time', 'asc');

        // Filter by category
        if ($request->has('category_id')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $auctions = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $auctions->through(fn($auction) => $this->formatAuction($auction)),
            'meta' => [
                'current_page' => $auctions->currentPage(),
                'last_page' => $auctions->lastPage(),
                'per_page' => $auctions->perPage(),
                'total' => $auctions->total(),
            ],
        ]);
    }

    /**
     * Get all auctions (including ended)
     */
    public function all(Request $request): JsonResponse
    {
        $query = Auction::with(['item.images', 'item.category', 'winner'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $auctions = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $auctions->through(fn($auction) => $this->formatAuction($auction)),
            'meta' => [
                'current_page' => $auctions->currentPage(),
                'last_page' => $auctions->lastPage(),
                'per_page' => $auctions->perPage(),
                'total' => $auctions->total(),
            ],
        ]);
    }

    /**
     * Get auction detail
     */
    public function show(Auction $auction): JsonResponse
    {
        $auction->load([
            'item.images',
            'item.category',
            'item.condition',
            'item.user',
            'bids.user',
            'winner',
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->formatAuction($auction, true),
        ]);
    }

    /**
     * Place a bid
     */
    public function placeBid(Request $request, Auction $auction): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if auction is active
        if (!$auction->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Lelang tidak aktif atau sudah berakhir.',
            ], 400);
        }

        $user = $request->user();
        $bidAmount = (float) $request->amount;

        // Check if user is owner of item
        if ($auction->item->user_id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menawar barang milik sendiri.',
            ], 400);
        }

        // Calculate minimum bid
        $minimumBid = $auction->current_price + $auction->item->minimum_bid_increment;

        if ($bidAmount < $minimumBid) {
            return response()->json([
                'success' => false,
                'message' => "Tawaran minimum adalah Rp " . number_format($minimumBid, 0, ',', '.'),
                'minimum_bid' => $minimumBid,
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Get previous highest bidder to notify
            $previousHighestBid = $auction->bids()->orderBy('amount', 'desc')->first();

            // Create bid
            $bid = Bid::create([
                'auction_id' => $auction->id,
                'user_id' => $user->id,
                'amount' => $bidAmount,
                'ip_address' => $request->ip(),
            ]);

            // Update auction current price and total bids
            $auction->update([
                'current_price' => $bidAmount,
                'total_bids' => $auction->total_bids + 1,
            ]);

            // Notify previous highest bidder if exists and different from current bidder
            if ($previousHighestBid && $previousHighestBid->user_id !== $user->id) {
                Notification::createForUser(
                    $previousHighestBid->user_id,
                    'Anda Telah Dikalahkan!',
                    "Tawaran Anda pada \"{$auction->item->name}\" telah dikalahkan dengan tawaran Rp " . number_format($bidAmount, 0, ',', '.'),
                    Notification::TYPE_OUTBID,
                    'auction',
                    $auction->id
                );
            }

            DB::commit();

            // Broadcast new bid event
            broadcast(new NewBidEvent($auction, $bid, $user))->toOthers();

            $auction->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Tawaran berhasil diajukan!',
                'data' => [
                    'bid' => [
                        'id' => $bid->id,
                        'amount' => (float) $bid->amount,
                        'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
                        'created_at' => $bid->created_at->toIso8601String(),
                    ],
                    'auction' => [
                        'current_price' => (float) $auction->current_price,
                        'total_bids' => $auction->total_bids,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan tawaran. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Get auction bids
     */
    public function bids(Auction $auction): JsonResponse
    {
        $bids = $auction->bids()
            ->with('user:id,name')
            ->orderBy('amount', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bids->map(fn($bid) => [
                'id' => $bid->id,
                'amount' => (float) $bid->amount,
                'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
                'user' => [
                    'id' => $bid->user->id,
                    'name' => $bid->user->name,
                ],
                'is_winning' => $bid->is_winning,
                'created_at' => $bid->created_at->toIso8601String(),
            ]),
        ]);
    }

    /**
     * Format auction for response
     */
    private function formatAuction(Auction $auction, bool $detailed = false): array
    {
        $data = [
            'id' => $auction->id,
            'status' => $auction->status,
            'current_price' => (float) $auction->current_price,
            'formatted_price' => 'Rp ' . number_format($auction->current_price, 0, ',', '.'),
            'total_bids' => $auction->total_bids,
            'start_time' => $auction->start_time->toIso8601String(),
            'end_time' => $auction->end_time->toIso8601String(),
            'time_remaining' => $auction->time_remaining,
            'is_active' => $auction->isActive(),
            'item' => $auction->item ? [
                'id' => $auction->item->id,
                'name' => $auction->item->name,
                'description' => mb_substr($auction->item->description, 0, 200) . (strlen($auction->item->description) > 200 ? '...' : ''),
                'starting_price' => (float) $auction->item->starting_price,
                'minimum_bid_increment' => (float) $auction->item->minimum_bid_increment,
                'category' => $auction->item->category ? [
                    'id' => $auction->item->category->id,
                    'name' => $auction->item->category->name,
                ] : null,
                'primary_image' => $auction->item->primaryImage
                    ? asset('storage/' . $auction->item->primaryImage->image_path)
                    : null,
            ] : null,
        ];

        if ($detailed) {
            $data['item']['description'] = $auction->item->description;
            $data['item']['images'] = $auction->item->images->map(fn($img) => [
                'id' => $img->id,
                'url' => asset('storage/' . $img->image_path),
                'thumbnail_url' => $img->thumbnail_path ? asset('storage/' . $img->thumbnail_path) : asset('storage/' . $img->image_path),
                'is_primary' => $img->is_primary,
            ]);
            $data['item']['condition'] = $auction->item->condition ? [
                'id' => $auction->item->condition->id,
                'name' => $auction->item->condition->name,
                'quality_rating' => $auction->item->condition->quality_rating,
            ] : null;
            $data['item']['owner'] = $auction->item->user ? [
                'id' => $auction->item->user->id,
                'name' => $auction->item->user->name,
            ] : null;

            $data['bids'] = $auction->bids->take(10)->map(fn($bid) => [
                'id' => $bid->id,
                'amount' => (float) $bid->amount,
                'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
                'user' => [
                    'id' => $bid->user->id,
                    'name' => $bid->user->name,
                ],
                'created_at' => $bid->created_at->toIso8601String(),
            ]);

            if ($auction->winner) {
                $data['winner'] = [
                    'id' => $auction->winner->id,
                    'name' => $auction->winner->name,
                ];
                $data['final_price'] = (float) $auction->final_price;
                $data['formatted_final_price'] = 'Rp ' . number_format($auction->final_price, 0, ',', '.');
            }
        }

        return $data;
    }
}
