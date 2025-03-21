<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Enums\UserEnum;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

// Service class nhận dữ liệu từ controller, vieets các logic cần thiết và thao tác với repository và trả về cho controller
class UserService implements UserServiceInterface
{
    // Instance of UserRepository
    protected $userRepo;
    // Constructor
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function getAllUser()
    {
        return $this->userRepo->allUser();
    }

    public function findUser($id)
    {
        return $this->userRepo->findUser($id);
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepo->createUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepo->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        $user = $this->findUser($id);
        if (!$user) {
            return false;
        }

        $user->delete();
        return true;
    }

    public function authenticate(array $data)
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $accessToken = $user->createToken('auth_token')->accessToken;
            return [
                'user' => $user,
                'accessToken' => $accessToken,
                'tokenType' => 'Bearer',
                'expiresIn' => Passport::tokensExpireIn(),
            ];
        }
    }

    public function changePassword($id, array $data)
    {
        $user = $this->findUser($id);
        if (!$user) {
            return UserEnum::USER_NOT_FOUND;
        }

        if (!Hash::check($data['oldPassword'], $user->password)) {
            return UserEnum::OLD_PASSWORD_INCORRECT;
        }

        $user->password = bcrypt($data['newPassword']);
        $user->save();
        return UserEnum::PASSWORD_CHANGED;
    }
}
