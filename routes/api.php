<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasyarakatController;


Route::post('/masyarakat/register', [MasyarakatController::class, 'register']);
Route::post('/masyarakat/login', [MasyarakatController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/masyarakat/profile', function (Request $request) {
        return $request->user();
    });
});
