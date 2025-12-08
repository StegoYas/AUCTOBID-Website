<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Public auction channel - anyone can subscribe
Broadcast::channel('auction.{auctionId}', function () {
    return true;
});

// Private auction channel for authenticated users
Broadcast::channel('auction.{auctionId}.private', function ($user, $auctionId) {
    return $user !== null;
});

// User notification channel
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Admin channel
Broadcast::channel('admin', function ($user) {
    return $user->isAdmin() || $user->isPetugas();
});
