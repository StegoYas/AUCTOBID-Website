<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Api\MasyarakatController;
use App\Http\Controllers\Api\PetugasController;


Route::post('/masyarakat/register', [MasyarakatController::class, 'register']);
Route::post('/masyarakat/login', [MasyarakatController::class, 'login']);
Route::post('/petugas/register', [PetugasController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/masyarakat/profile', function (Request $request) {
        return $request->user();
    });



    Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete(); // logout 1 device
        return response()->json(['message' => 'Logged out']);
    });
});
