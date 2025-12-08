<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Get user's bid history
     */
    public function myBids(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $query = Bid::with(['auction.item.images', 'auction.item.category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by winning status
        if ($request->has('winning')) {
            $query->where('is_winning', $request->boolean('winning'));
        }

        $bids = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $bids->through(fn($bid) => $this->formatBid($bid)),
            'meta' => [
                'current_page' => $bids->currentPage(),
                'last_page' => $bids->lastPage(),
                'per_page' => $bids->perPage(),
                'total' => $bids->total(),
            ],
        ]);
    }

    /**
     * Get user's won auctions
     */
    public function myWins(Request $request): JsonResponse
    {
        $user = $request->user();

        $wins = Bid::with(['auction.item.images', 'auction.item.category'])
            ->where('user_id', $user->id)
            ->where('is_winning', true)
            ->whereHas('auction', function ($q) {
                $q->where('status', 'ended');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $wins->through(fn($bid) => [
                'id' => $bid->id,
                'winning_amount' => (float) $bid->amount,
                'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
                'auction' => $this->formatAuctionForBid($bid->auction),
                'payment_status' => $bid->auction->payment_status,
                'won_at' => $bid->created_at->toIso8601String(),
            ]),
            'meta' => [
                'current_page' => $wins->currentPage(),
                'last_page' => $wins->lastPage(),
                'per_page' => $wins->perPage(),
                'total' => $wins->total(),
            ],
        ]);
    }

    /**
     * Get user's active bids (auctions still running)
     */
    public function myActiveBids(Request $request): JsonResponse
    {
        $user = $request->user();

        // Get unique auctions where user has bid and auction is still active
        $auctionIds = Bid::where('user_id', $user->id)
            ->whereHas('auction', function ($q) {
                $q->where('status', 'active');
            })
            ->distinct()
            ->pluck('auction_id');

        $activeBids = Bid::with(['auction.item.images', 'auction.item.category'])
            ->where('user_id', $user->id)
            ->whereIn('auction_id', $auctionIds)
            ->whereIn('id', function ($query) use ($user) {
                // Get only the latest bid per auction for this user
                $query->selectRaw('MAX(id)')
                    ->from('bids')
                    ->where('user_id', $user->id)
                    ->groupBy('auction_id');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $activeBids->map(function ($bid) {
                $isCurrentlyWinning = $bid->auction->bids()
                    ->orderBy('amount', 'desc')
                    ->first()
                    ?->user_id === $bid->user_id;

                return [
                    'id' => $bid->id,
                    'my_bid_amount' => (float) $bid->amount,
                    'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
                    'is_currently_winning' => $isCurrentlyWinning,
                    'auction' => $this->formatAuctionForBid($bid->auction),
                    'bid_at' => $bid->created_at->toIso8601String(),
                ];
            }),
        ]);
    }

    /**
     * Format bid for response
     */
    private function formatBid(Bid $bid): array
    {
        return [
            'id' => $bid->id,
            'amount' => (float) $bid->amount,
            'formatted_amount' => 'Rp ' . number_format($bid->amount, 0, ',', '.'),
            'is_winning' => $bid->is_winning,
            'auction' => $this->formatAuctionForBid($bid->auction),
            'created_at' => $bid->created_at->toIso8601String(),
        ];
    }

    /**
     * Format auction for bid response
     */
    private function formatAuctionForBid($auction): ?array
    {
        if (!$auction) {
            return null;
        }

        return [
            'id' => $auction->id,
            'status' => $auction->status,
            'current_price' => (float) $auction->current_price,
            'formatted_price' => 'Rp ' . number_format($auction->current_price, 0, ',', '.'),
            'total_bids' => $auction->total_bids,
            'end_time' => $auction->end_time->toIso8601String(),
            'time_remaining' => $auction->time_remaining,
            'item' => $auction->item ? [
                'id' => $auction->item->id,
                'name' => $auction->item->name,
                'category' => $auction->item->category?->name,
                'primary_image' => $auction->item->primaryImage
                    ? asset('storage/' . $auction->item->primaryImage->image_path)
                    : null,
            ] : null,
        ];
    }
}
