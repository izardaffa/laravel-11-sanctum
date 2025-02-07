<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(RegisterController::class)->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('blogs', BlogController::class);
    Route::get('user', [RegisterController::class, 'getUserData'])->name('user');
    Route::post('logout', [RegisterController::class, 'logout'])->name('logout');
    // Route::get('user', function(Request $request) {
    //     return $request->user();
    // })->name('user');
});
