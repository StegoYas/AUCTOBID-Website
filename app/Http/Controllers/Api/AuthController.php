<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new masyarakat user
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'identity_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => User::ROLE_MASYARAKAT,
            'status' => User::STATUS_PENDING,
        ];

        // Handle identity photo upload
        if ($request->hasFile('identity_photo')) {
            $path = $request->file('identity_photo')->store('identity-photos', 'public');
            $data['identity_photo'] = $path;
        }

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Silakan tunggu persetujuan admin.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                ],
            ],
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Check user status
        if ($user->status === User::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda masih menunggu persetujuan admin.',
                'status' => 'pending',
            ], 403);
        }

        if ($user->status === User::STATUS_REJECTED) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Anda ditolak oleh admin.',
                'status' => 'rejected',
            ], 403);
        }

        if ($user->status === User::STATUS_SUSPENDED) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.',
                'status' => 'suspended',
            ], 403);
        }

        // Only masyarakat can login via mobile
        if ($user->role !== User::ROLE_MASYARAKAT) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini tidak dapat digunakan di aplikasi mobile.',
            ], 403);
        }

        // Create token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'role' => $user->role,
                    'status' => $user->status,
                    'profile_photo_url' => $user->profile_photo_url,
                ],
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Get current user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'role' => $user->role,
                    'status' => $user->status,
                    'profile_photo_url' => $user->profile_photo_url,
                    'identity_photo_url' => $user->identity_photo_url,
                    'created_at' => $user->created_at->toIso8601String(),
                ],
            ],
        ]);
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Delete current token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
            ],
        ]);
    }
}
