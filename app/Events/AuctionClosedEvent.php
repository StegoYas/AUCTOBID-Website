<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Auction;

class AuctionClosedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auctionId;
    public $auction;

    /**
     * Create a new event instance.
     */
    public function __construct(Auction $auction)
    {
        $this->auctionId = $auction->id;
        
        $auction->load(['item', 'winner']);
        
        $this->auction = [
            'id' => $auction->id,
            'status' => $auction->status,
            'final_price' => $auction->final_price,
            'formatted_final_price' => 'Rp ' . number_format((float) ($auction->final_price ?? 0), 0, ',', '.'),
            'total_bids' => $auction->total_bids,
            'winner' => $auction->winner ? [
                'id' => $auction->winner->id,
                'name' => $auction->winner->name,
            ] : null,
            'item' => [
                'id' => $auction->item->id,
                'name' => $auction->item->name,
            ],
            'closed_at' => $auction->closed_at ? $auction->closed_at->toIso8601String() : null,
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
        return 'auction-closed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'auction' => $this->auction,
        ];
    }
}
