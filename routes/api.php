<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuctionController;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public data
    Route::get('/categories', [ItemController::class, 'categories']);
    Route::get('/conditions', [ItemController::class, 'conditions']);

    // Public auctions
    Route::get('/auctions', [AuctionController::class, 'index']);
    Route::get('/auctions/{auction}', [AuctionController::class, 'show']);
    Route::get('/auctions/{auction}/bids', [AuctionController::class, 'bids']);

    // Authenticated routes
    Route::middleware(['auth:sanctum', 'role:masyarakat'])->group(function () {
        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh-token', [AuthController::class, 'refresh']);

        // Profile
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']);
        Route::post('/profile/identity-photo', [ProfileController::class, 'updateIdentityPhoto']);
        Route::put('/profile/password', [ProfileController::class, 'changePassword']);
        Route::get('/profile/statistics', [ProfileController::class, 'statistics']);

        // Items
        Route::post('/items', [ItemController::class, 'store']);
        Route::get('/my-items', [ItemController::class, 'myItems']);
        Route::get('/items/{item}', [ItemController::class, 'show']);

        // Bidding
        Route::post('/auctions/{auction}/bid', [AuctionController::class, 'placeBid']);
        Route::get('/auctions/all', [AuctionController::class, 'all']);

        // Bid history
        Route::get('/my-bids', [BidController::class, 'myBids']);
        Route::get('/my-wins', [BidController::class, 'myWins']);
        Route::get('/my-active-bids', [BidController::class, 'myActiveBids']);

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);

        // Payment
        Route::get('/auctions/{auction}/payment', [PaymentController::class, 'getPaymentDetails']);
        Route::post('/auctions/{auction}/pay', [PaymentController::class, 'processPayment']);
        Route::get('/payment-history', [PaymentController::class, 'paymentHistory']);
    });
});
