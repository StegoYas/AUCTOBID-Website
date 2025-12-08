<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Item;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * Show reports page
     */
    public function index(): View
    {
        return view('reports.index');
    }

    /**
     * Generate users report
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.users-pdf', compact('users'));
            return $pdf->download('laporan-pengguna-' . date('Y-m-d') . '.pdf');
        }

        // Excel export
        return Excel::download(new \App\Exports\UsersExport($users), 'laporan-pengguna-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Generate auctions report
     */
    public function auctions(Request $request)
    {
        $query = Auction::with(['item', 'winner', 'openedBy']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $auctions = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalRevenue = $auctions->where('status', 'ended')->sum('final_price');
        $totalCommission = $auctions->where('status', 'ended')->sum('commission_amount');

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.auctions-pdf', compact('auctions', 'totalRevenue', 'totalCommission'));
            return $pdf->download('laporan-lelang-' . date('Y-m-d') . '.pdf');
        }

        return Excel::download(new \App\Exports\AuctionsExport($auctions), 'laporan-lelang-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Generate items report
     */
    public function items(Request $request)
    {
        $query = Item::with(['user', 'category', 'condition']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.items-pdf', compact('items'));
            return $pdf->download('laporan-barang-' . date('Y-m-d') . '.pdf');
        }

        return Excel::download(new \App\Exports\ItemsExport($items), 'laporan-barang-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Generate transactions report
     */
    public function transactions(Request $request)
    {
        $query = Auction::with(['item', 'winner'])
            ->where('status', 'ended')
            ->whereNotNull('winner_id');

        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('from_date')) {
            $query->whereDate('closed_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('closed_at', '<=', $request->to_date);
        }

        $transactions = $query->orderBy('closed_at', 'desc')->get();

        $totalAmount = $transactions->sum('final_price');
        $totalCommission = $transactions->sum('commission_amount');
        $paidAmount = $transactions->where('payment_status', 'paid')->sum('final_price');

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.transactions-pdf', compact('transactions', 'totalAmount', 'totalCommission', 'paidAmount'));
            return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
        }

        return Excel::download(new \App\Exports\TransactionsExport($transactions), 'laporan-transaksi-' . date('Y-m-d') . '.xlsx');
    }
}
