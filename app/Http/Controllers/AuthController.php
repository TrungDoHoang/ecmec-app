<?php

namespace App\Http\Controllers;

use App\Enums\UserEnum;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = $this->authService->authenticate($credentials);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    // Lấy thông tin user hiện tại
    public function me()
    {
        $user = $this->authService->me();
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    // Refresh token
    public function refreshToken()
    {
        $newToken = $this->authService->refreshToken();
        return response()->json(['access_token' => $newToken], Response::HTTP_OK);
    }

    // Đăng xuất
    public function logout()
    {
        $message = $this->authService->logout();
        return response()->json(['message' => $message], Response::HTTP_OK);
    }

    // Đăng xuất trên tất cả các thiết bị
    public function logoutAllDevices()
    {
        $message = $this->authService->logoutAllDevice();
        return response()->json(['message' => $message], Response::HTTP_OK);
    }

    public function register(UserRequest $request)
    {
        $userData = $request->validated();
        $user = $this->authService->register($userData);
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $data = $request->validated();
        $result = $this->authService->changePassword($id, $data);

        if ($result === UserEnum::USER_NOT_FOUND) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if ($result === UserEnum::OLD_PASSWORD_INCORRECT) {
            return response()->json(['message' => 'Old password is incorrect'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Password changed successfully'], Response::HTTP_OK);
    }
}
