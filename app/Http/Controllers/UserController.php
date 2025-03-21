<?php

namespace App\Http\Controllers;

use App\Enums\UserEnum;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = $this->userService->authenticate($credentials);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function index()
    {
        $users = $this->userService->getAllUser();
        return response()->json($users, Response::HTTP_OK);
    }

    public function store(UserRequest $request)
    {
        $userData = $request->validated();
        $user = $this->userService->createUser($userData);
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function update(UserRequest $request, $id)
    {
        $userData = $request->validated();
        $user = $this->userService->updateUser($id, $userData);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $data = $request->validated();
        $result = $this->userService->changePassword($id, $data);

        if ($result === UserEnum::USER_NOT_FOUND) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if ($result === UserEnum::OLD_PASSWORD_INCORRECT) {
            return response()->json(['message' => 'Old password is incorrect'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Password changed successfully'], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'User deleted'], Response::HTTP_OK);
    }
}
