<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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


Route::middleware(['auth:sanctum'])->group(function () {
    // Lấy danh sách người dùng
    Route::get('users', [UserController::class, 'index']);
    // Tạo người dùng mới
    Route::post('users', [UserController::class, 'store']);
    // Lấy thông tin người dùng        
    Route::get('users/{id}', [UserController::class, 'show']);
    // Cập nhật thông tin người dùng
    Route::put('users/{id}', [UserController::class, 'update']);
    // Xóa người dùng
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    // Thay đổi mật khẩu
    Route::post('users/change-password/{id}', [UserController::class, 'changePassword']);
});

// Đăng nhập
Route::post('login', [UserController::class, 'login']);
