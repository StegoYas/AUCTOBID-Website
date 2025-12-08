<?php

namespace App\Http\Controllers\Web;

use App\Events\AuctionEndedEvent;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuctionController extends Controller
{
    /**
     * List all auctions
     */
    public function index(Request $request): View
    {
        $query = Auction::with(['item.images', 'item.category', 'winner', 'openedBy']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $auctions = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('auctions.index', compact('auctions'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $items = Item::with('images')
            ->where('status', 'approved')
            ->whereDoesntHave('auction', function ($q) {
                $q->whereIn('status', ['scheduled', 'active']);
            })
            ->get();

        $defaultDuration = Setting::getValue('default_auction_duration', 7);

        return view('auctions.form', [
            'auction' => null,
            'items' => $items,
            'defaultDuration' => $defaultDuration,
        ]);
    }

    /**
     * Store auction (open auction)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date|after_or_equal:now',
            'duration_days' => 'required|integer|min:1|max:30',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Check if item is approved and not already in auction
        if ($item->status !== 'approved') {
            return back()->with('error', 'Item belum disetujui atau sedang dalam lelang.');
        }

        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addDays($request->duration_days);

        // Determine initial status
        $status = $startTime->lte(now()) ? 'active' : 'scheduled';

        $auction = Auction::create([
            'item_id' => $item->id,
            'opened_by' => $request->user()->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'current_price' => $item->starting_price,
            'status' => $status,
        ]);

        // Update item status
        if ($status === 'active') {
            $item->update(['status' => 'auctioning']);

            // Notify item owner
            Notification::createForUser(
                $item->user_id,
                'Lelang Dimulai!',
                "Lelang untuk item \"{$item->name}\" telah dimulai.",
                Notification::TYPE_AUCTION_STARTED,
                'auction',
                $auction->id
            );
        }

        return redirect()->route('auctions.index')->with('success', 'Lelang berhasil dibuat.');
    }

    /**
     * Show auction details
     */
    public function show(Auction $auction): View
    {
        $auction->load(['item.images', 'item.user', 'item.category', 'item.condition', 'bids.user', 'winner', 'openedBy', 'closedBy']);

        return view('auctions.show', compact('auction'));
    }

    /**
     * Start scheduled auction
     */
    public function start(Auction $auction): RedirectResponse
    {
        if ($auction->status !== 'scheduled') {
            return back()->with('error', 'Lelang tidak dalam status terjadwal.');
        }

        $auction->update([
            'status' => 'active',
            'start_time' => now(),
        ]);

        $auction->item->update(['status' => 'auctioning']);

        // Notify item owner
        Notification::createForUser(
            $auction->item->user_id,
            'Lelang Dimulai!',
            "Lelang untuk item \"{$auction->item->name}\" telah dimulai.",
            Notification::TYPE_AUCTION_STARTED,
            'auction',
            $auction->id
        );

        return back()->with('success', 'Lelang berhasil dimulai.');
    }

    /**
     * Close auction and determine winner
     */
    public function close(Request $request, Auction $auction): RedirectResponse
    {
        if ($auction->status !== 'active') {
            return back()->with('error', 'Lelang tidak aktif.');
        }

        // Calculate winner using stored procedure
        $result = $auction->calculateWinner();
        
        $auction->update([
            'closed_by' => $request->user()->id,
        ]);

        // Notify participants
        if ($result['winner_id']) {
            // Notify winner
            Notification::createForUser(
                $result['winner_id'],
                'Selamat! Anda Memenangkan Lelang',
                "Anda memenangkan lelang \"{$auction->item->name}\" dengan harga Rp " . number_format($result['final_price'], 0, ',', '.'),
                Notification::TYPE_AUCTION_WON,
                'auction',
                $auction->id
            );

            // Notify losers
            $loserIds = $auction->bids()
                ->where('user_id', '!=', $result['winner_id'])
                ->distinct()
                ->pluck('user_id');

            foreach ($loserIds as $loserId) {
                Notification::createForUser(
                    $loserId,
                    'Lelang Berakhir',
                    "Maaf, Anda tidak memenangkan lelang \"{$auction->item->name}\".",
                    Notification::TYPE_AUCTION_LOST,
                    'auction',
                    $auction->id
                );
            }

            // Notify item owner
            Notification::createForUser(
                $auction->item->user_id,
                'Lelang Berhasil!',
                "Item \"{$auction->item->name}\" terjual dengan harga Rp " . number_format($result['final_price'], 0, ',', '.'),
                Notification::TYPE_AUCTION_ENDED,
                'auction',
                $auction->id
            );
        } else {
            // No winner
            Notification::createForUser(
                $auction->item->user_id,
                'Lelang Berakhir Tanpa Pemenang',
                "Lelang untuk item \"{$auction->item->name}\" berakhir tanpa ada penawar.",
                Notification::TYPE_AUCTION_ENDED,
                'auction',
                $auction->id
            );
        }

        // Broadcast auction ended
        broadcast(new AuctionEndedEvent($auction));

        return back()->with('success', 'Lelang berhasil ditutup.');
    }

    /**
     * Cancel auction
     */
    public function cancel(Request $request, Auction $auction): RedirectResponse
    {
        if (!in_array($auction->status, ['scheduled', 'active'])) {
            return back()->with('error', 'Lelang tidak dapat dibatalkan.');
        }

        // Check if there are bids
        if ($auction->status === 'active' && $auction->bids()->exists()) {
            return back()->with('error', 'Lelang dengan tawaran tidak dapat dibatalkan.');
        }

        $auction->update([
            'status' => 'cancelled',
            'closed_by' => $request->user()->id,
            'closed_at' => now(),
        ]);

        // Reset item status
        $auction->item->update(['status' => 'approved']);

        return back()->with('success', 'Lelang berhasil dibatalkan.');
    }
}
