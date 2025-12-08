<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }
            return redirect()->route('login');
        }

        // Check if user is approved
        if (!$user->isApproved()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda belum disetujui atau telah dinonaktifkan.',
                    'status' => $user->status,
                ], 403);
            }
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda belum disetujui.');
        }

        // Check if user has required role
        if (!empty($roles) && !in_array($user->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke halaman ini.',
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
