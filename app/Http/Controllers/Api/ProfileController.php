<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Update profile
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update($request->only(['name', 'phone', 'address']));

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'profile_photo_url' => $user->profile_photo_url,
                ],
            ],
        ]);
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui.',
            'data' => [
                'profile_photo_url' => $user->profile_photo_url,
            ],
        ]);
    }

    /**
     * Update identity photo
     */
    public function updateIdentityPhoto(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'identity_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Delete old photo if exists
        if ($user->identity_photo) {
            Storage::disk('public')->delete($user->identity_photo);
        }

        // Store new photo
        $path = $request->file('identity_photo')->store('identity-photos', 'public');
        $user->update(['identity_photo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto identitas berhasil diperbarui.',
            'data' => [
                'identity_photo_url' => $user->identity_photo_url,
            ],
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah.',
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Revoke all tokens except current
        $currentToken = $request->user()->currentAccessToken();
        $request->user()->tokens()->where('id', '!=', $currentToken->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }

    /**
     * Get user statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $user = $request->user();

        $totalItems = $user->items()->count();
        $approvedItems = $user->items()->where('status', 'approved')->count();
        $soldItems = $user->items()->where('status', 'sold')->count();
        
        $totalBids = $user->bids()->count();
        $wonAuctions = $user->wonAuctions()->count();
        
        $totalSpent = $user->wonAuctions()
            ->where('payment_status', 'paid')
            ->sum('final_price');

        return response()->json([
            'success' => true,
            'data' => [
                'items' => [
                    'total' => $totalItems,
                    'approved' => $approvedItems,
                    'sold' => $soldItems,
                ],
                'bidding' => [
                    'total_bids' => $totalBids,
                    'won_auctions' => $wonAuctions,
                    'total_spent' => (float) $totalSpent,
                    'formatted_total_spent' => 'Rp ' . number_format($totalSpent, 0, ',', '.'),
                ],
            ],
        ]);
    }
}
