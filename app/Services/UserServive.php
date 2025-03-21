<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Repositories\UserRepository;

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
        return $this->userRepo->createUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepo->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepo->deleteUser($id);
    }
}
