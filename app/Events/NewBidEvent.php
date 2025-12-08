<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bid;
use App\Models\Auction;

class NewBidEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auctionId;
    public $bid;
    public $currentPrice;
    public $totalBids;
    public $timeRemaining;

    /**
     * Create a new event instance.
     */
    public function __construct(Bid $bid, Auction $auction)
    {
        $this->auctionId = $auction->id;
        $this->currentPrice = $auction->current_price;
        $this->totalBids = $auction->total_bids;
        $this->timeRemaining = $auction->time_remaining;
        
        $this->bid = [
            'id' => $bid->id,
            'amount' => $bid->amount,
            'formatted_amount' => 'Rp ' . number_format((float) $bid->amount, 0, ',', '.'),
            'user' => [
                'id' => $bid->user->id,
                'name' => $bid->user->name,
            ],
            'created_at' => $bid->created_at->toIso8601String(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('auction.' . $this->auctionId),
        ];
    }

    /**
     * Get the event name to broadcast as.
     */
    public function broadcastAs(): string
    {
        return 'new-bid';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'auction_id' => $this->auctionId,
            'bid' => $this->bid,
            'current_price' => $this->currentPrice,
            'formatted_price' => 'Rp ' . number_format((float) $this->currentPrice, 0, ',', '.'),
            'total_bids' => $this->totalBids,
            'time_remaining' => $this->timeRemaining,
        ];
    }
}
