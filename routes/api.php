<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Need authentication
Route::middleware(['auth:api'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('logout-all-devices', [AuthController::class, 'logoutAllDevices'])->name('logout.all');
    Route::get('me', [AuthController::class, 'me'])->name('me');

    // Api
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore']);
});

// Not need authentication
Route::group([], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh.token');

    // Verify email
    Route::post('/verify-email', [AuthController::class, 'verifyEmailRegister']);

    // Gửi lại email verify
    Route::post('/resend-verification', [AuthController::class, 'resendEmailRegister']);

    // Gửi email Fogot Password
    Route::post('forgot-password', [AuthController::class, 'sendMailFgPassword']);

    // Verify email Fogot Password
    Route::post('reset-password', [AuthController::class, 'verifyFogotPassword']);
});
