<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ConditionController;
use App\Http\Controllers\Web\ItemController;
use App\Http\Controllers\Web\AuctionController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/pending', [UserController::class, 'pending'])->name('users.pending');
        Route::get('/users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::get('/users/create-petugas', [UserController::class, 'createPetugas'])->name('users.create-petugas');
        Route::post('/users/store-petugas', [UserController::class, 'storePetugas'])->name('users.store-petugas');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
        Route::post('/users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
        Route::post('/users/{user}/unsuspend', [UserController::class, 'unsuspend'])->name('users.unsuspend');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Categories
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::post('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');

        // Conditions
        Route::resource('conditions', ConditionController::class)->except(['show']);
        Route::post('/conditions/{condition}/toggle', [ConditionController::class, 'toggle'])->name('conditions.toggle');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/users', [ReportController::class, 'users'])->name('reports.users');
        Route::get('/reports/auctions', [ReportController::class, 'auctions'])->name('reports.auctions');
        Route::get('/reports/items', [ReportController::class, 'items'])->name('reports.items');
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    });

    // Items (Admin & Petugas)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/pending', [ItemController::class, 'pending'])->name('items.pending');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::post('/items/{item}/approve', [ItemController::class, 'approve'])->name('items.approve');
    Route::post('/items/{item}/reject', [ItemController::class, 'reject'])->name('items.reject');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Auctions (Admin & Petugas)
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::post('/auctions/{auction}/start', [AuctionController::class, 'start'])->name('auctions.start');
    Route::post('/auctions/{auction}/close', [AuctionController::class, 'close'])->name('auctions.close');
    Route::post('/auctions/{auction}/cancel', [AuctionController::class, 'cancel'])->name('auctions.cancel');
});

// Redirect home to dashboard or login
Route::get('/home', function () {
    return redirect()->route('dashboard');
});
