<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
    Route::post('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh.token');

    // Api
    Route::resource('users', UserController::class);
});

// Not need authentication
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
