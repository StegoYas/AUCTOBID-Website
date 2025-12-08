<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Get payment details for won auction
     */
    public function getPaymentDetails(Request $request, Auction $auction): JsonResponse
    {
        $user = $request->user();

        // Check if user is winner
        if ($auction->winner_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan pemenang lelang ini.',
            ], 403);
        }

        // Check if auction is ended
        if ($auction->status !== 'ended') {
            return response()->json([
                'success' => false,
                'message' => 'Lelang belum berakhir.',
            ], 400);
        }

        $auction->load('item.images');

        return response()->json([
            'success' => true,
            'data' => [
                'auction_id' => $auction->id,
                'item' => [
                    'id' => $auction->item->id,
                    'name' => $auction->item->name,
                    'primary_image' => $auction->item->primaryImage
                        ? asset('storage/' . $auction->item->primaryImage->image_path)
                        : null,
                ],
                'final_price' => (float) $auction->final_price,
                'commission_amount' => (float) $auction->commission_amount,
                'total_amount' => (float) ($auction->final_price + $auction->commission_amount),
                'formatted_final_price' => 'Rp ' . number_format($auction->final_price, 0, ',', '.'),
                'formatted_commission' => 'Rp ' . number_format($auction->commission_amount, 0, ',', '.'),
                'formatted_total' => 'Rp ' . number_format($auction->final_price + $auction->commission_amount, 0, ',', '.'),
                'payment_status' => $auction->payment_status,
                'paid_at' => $auction->paid_at?->toIso8601String(),
                // Mock payment info
                'payment_methods' => [
                    [
                        'id' => 'bank_transfer',
                        'name' => 'Transfer Bank',
                        'banks' => [
                            ['code' => 'BCA', 'name' => 'Bank Central Asia', 'account' => '1234567890'],
                            ['code' => 'BNI', 'name' => 'Bank Negara Indonesia', 'account' => '0987654321'],
                            ['code' => 'MANDIRI', 'name' => 'Bank Mandiri', 'account' => '1122334455'],
                        ],
                    ],
                    [
                        'id' => 'virtual_account',
                        'name' => 'Virtual Account',
                        'description' => 'Bayar melalui virtual account',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Process mock payment
     */
    public function processPayment(Request $request, Auction $auction): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|in:bank_transfer,virtual_account',
            'bank_code' => 'required_if:payment_method,bank_transfer|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        // Check if user is winner
        if ($auction->winner_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan pemenang lelang ini.',
            ], 403);
        }

        // Check if already paid
        if ($auction->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran sudah dilakukan.',
            ], 400);
        }

        // Mock payment processing - always succeeds
        $transactionId = 'TXN-' . strtoupper(Str::random(12));

        // Update auction payment status
        $auction->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        // Notify winner
        Notification::createForUser(
            $user->id,
            'Pembayaran Berhasil!',
            "Pembayaran untuk \"{$auction->item->name}\" telah berhasil. ID Transaksi: {$transactionId}",
            Notification::TYPE_PAYMENT_RECEIVED,
            'auction',
            $auction->id
        );

        // Notify item owner
        Notification::createForUser(
            $auction->item->user_id,
            'Pembayaran Diterima!',
            "Pembayaran untuk \"{$auction->item->name}\" telah diterima dari pemenang lelang.",
            Notification::TYPE_PAYMENT_RECEIVED,
            'auction',
            $auction->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil!',
            'data' => [
                'transaction_id' => $transactionId,
                'amount' => (float) ($auction->final_price + $auction->commission_amount),
                'formatted_amount' => 'Rp ' . number_format($auction->final_price + $auction->commission_amount, 0, ',', '.'),
                'payment_method' => $request->payment_method,
                'paid_at' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * Get user's payment history
     */
    public function paymentHistory(Request $request): JsonResponse
    {
        $user = $request->user();

        $payments = Auction::with('item.images')
            ->where('winner_id', $user->id)
            ->where('status', 'ended')
            ->orderBy('closed_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $payments->through(fn($auction) => [
                'auction_id' => $auction->id,
                'item' => [
                    'id' => $auction->item->id,
                    'name' => $auction->item->name,
                    'primary_image' => $auction->item->primaryImage
                        ? asset('storage/' . $auction->item->primaryImage->image_path)
                        : null,
                ],
                'final_price' => (float) $auction->final_price,
                'commission_amount' => (float) $auction->commission_amount,
                'total_amount' => (float) ($auction->final_price + $auction->commission_amount),
                'formatted_total' => 'Rp ' . number_format($auction->final_price + $auction->commission_amount, 0, ',', '.'),
                'payment_status' => $auction->payment_status,
                'paid_at' => $auction->paid_at?->toIso8601String(),
                'won_at' => $auction->closed_at->toIso8601String(),
            ]),
            'meta' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'per_page' => $payments->perPage(),
                'total' => $payments->total(),
            ],
        ]);
    }
}
