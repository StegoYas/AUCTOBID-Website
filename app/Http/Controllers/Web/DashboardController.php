<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Statistics
        $stats = [
            'total_users' => User::where('role', 'masyarakat')->count(),
            'pending_users' => User::where('role', 'masyarakat')->where('status', 'pending')->count(),
            'total_items' => Item::count(),
            'pending_items' => Item::where('status', 'pending')->count(),
            'active_auctions' => Auction::where('status', 'active')->count(),
            'completed_auctions' => Auction::where('status', 'ended')->count(),
        ];

        // Recent activities
        $recentItems = Item::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $activeAuctions = Auction::with(['item.images', 'item.category'])
            ->where('status', 'active')
            ->orderBy('end_time', 'asc')
            ->limit(5)
            ->get();

        $pendingUsers = User::where('role', 'masyarakat')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentItems', 'activeAuctions', 'pendingUsers', 'user'));
    }
}
