<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List all users
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show pending users
     */
    public function pending(): View
    {
        $users = User::where('role', 'masyarakat')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('users.pending', compact('users'));
    }

    /**
     * Show user details
     */
    public function show(User $user): View
    {
        $user->load(['items', 'bids', 'wonAuctions']);

        return view('users.show', compact('user'));
    }

    /**
     * Approve user
     */
    public function approve(Request $request, User $user): RedirectResponse
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'User tidak dalam status pending.');
        }

        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        // Send notification
        Notification::createForUser(
            $user->id,
            'Selamat! Akun Anda Disetujui',
            'Akun Anda telah disetujui oleh admin. Sekarang Anda dapat menggunakan semua fitur AUCTOBID.',
            Notification::TYPE_REGISTRATION_APPROVED
        );

        return back()->with('success', 'User berhasil disetujui.');
    }

    /**
     * Reject user
     */
    public function reject(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $user->update([
            'status' => 'rejected',
        ]);

        // Send notification
        Notification::createForUser(
            $user->id,
            'Pendaftaran Ditolak',
            'Maaf, pendaftaran Anda ditolak.' . ($request->reason ? ' Alasan: ' . $request->reason : ''),
            Notification::TYPE_REGISTRATION_REJECTED
        );

        return back()->with('success', 'User berhasil ditolak.');
    }

    /**
     * Suspend user
     */
    public function suspend(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update([
            'status' => 'suspended',
        ]);

        return back()->with('success', 'User berhasil dinonaktifkan.');
    }

    /**
     * Unsuspend user
     */
    public function unsuspend(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'User berhasil diaktifkan kembali.');
    }

    /**
     * Create petugas form
     */
    public function createPetugas(): View
    {
        return view('users.create-petugas');
    }

    /**
     * Store petugas
     */
    public function storePetugas(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'petugas',
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        return redirect()->route('users.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Revoke all tokens
        $user->tokens()->delete();

        return back()->with('success', 'Password berhasil direset.');
    }

    /**
     * Delete user
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
