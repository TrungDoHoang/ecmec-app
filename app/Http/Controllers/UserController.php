<?php

namespace App\Http\Controllers;

use App\Enums\FolderEnum;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $folder = request()->folder ?? FolderEnum::DEFAULT;
        $users = $this->userService->getAllUser($folder);
        return response()->json(UserResource::collection($users), Response::HTTP_OK);
    }

    public function show($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new UserResource($user), Response::HTTP_OK);
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

    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'User deleted'], Response::HTTP_OK);
    }

    public function restore($id)
    {
        echo $id;
        $user = $this->userService->restoreUser($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }
}
