<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;
    // create Instance of UserService
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUser();
        return response()->json($users)->status(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $request->validated();
        $user->password = bcrypt($user->password);
        return response()->json($this->userService->createUser($user))->status(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userService->findUser($id);
        return response()->json($user)->status(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $user = $request->validated();
        // Delete password field from request
        unset($user['password']);
        // Update user without password
        return response()->json($this->userService->updateUser($id, $user))->status(Response::HTTP_OK);
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $body = $request->validated();
        // Check old password with user password
        $user = $this->userService->findUser($id);
        if (!Hash::check($body['old_password'], $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'])->status(Response::HTTP_BAD_REQUEST);
        }
        $user->password = bcrypt($body->new_password);
        return response()->json($this->userService->updateUser($id, $user))->status(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json($this->userService->deleteUser($id))->status(Response::HTTP_OK);
    }
}
