<?php

namespace App\Http\Controllers;

use App\Enums\FolderEnum;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\HasPaginatedResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use HasPaginatedResponse;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $perPage = request()->input('per_page', 15); // Mặc định 15 items
        $page = request()->input('page', 1);
        $folder = request()->input('folder', FolderEnum::DEFAULT);
        $users = $this->userService->getAllUser($folder, $perPage, $page);
        return response()->json($this->paginatedResponse($users, UserResource::collection($users)));;
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
