<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * List all items
     */
    public function index(Request $request): View
    {
        $query = Item::with(['user', 'category', 'condition', 'images']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('items.index', compact('items'));
    }

    /**
     * Show pending items
     */
    public function pending(): View
    {
        $items = Item::with(['user', 'category', 'condition', 'images'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('items.pending', compact('items'));
    }

    /**
     * Show item details
     */
    public function show(Item $item): View
    {
        $item->load(['user', 'category', 'condition', 'images', 'auction.bids']);

        return view('items.show', compact('item'));
    }

    /**
     * Approve item
     */
    public function approve(Request $request, Item $item): RedirectResponse
    {
        if ($item->status !== 'pending') {
            return back()->with('error', 'Item tidak dalam status pending.');
        }

        $item->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        // Send notification
        Notification::createForUser(
            $item->user_id,
            'Item Disetujui!',
            "Item \"{$item->name}\" telah disetujui dan siap untuk dilelang.",
            Notification::TYPE_ITEM_APPROVED,
            'item',
            $item->id
        );

        return back()->with('success', 'Item berhasil disetujui.');
    }

    /**
     * Reject item
     */
    public function reject(Request $request, Item $item): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $item->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        // Send notification
        Notification::createForUser(
            $item->user_id,
            'Item Ditolak',
            "Maaf, item \"{$item->name}\" ditolak. Alasan: {$request->reason}",
            Notification::TYPE_ITEM_REJECTED,
            'item',
            $item->id
        );

        return back()->with('success', 'Item berhasil ditolak.');
    }

    /**
     * Delete item
     */
    public function destroy(Item $item): RedirectResponse
    {
        if ($item->status === 'auctioning') {
            return back()->with('error', 'Item yang sedang dilelang tidak dapat dihapus.');
        }

        // Delete images
        foreach ($item->images as $image) {
            if ($image->image_path) {
                \Storage::disk('public')->delete($image->image_path);
            }
            if ($image->thumbnail_path) {
                \Storage::disk('public')->delete($image->thumbnail_path);
            }
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }
}
