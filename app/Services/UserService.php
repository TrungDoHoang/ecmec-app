<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Enums\FolderEnum;
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

    public function getAllUser($folder, $perPage, $page)
    {
        if ($folder == FolderEnum::DELETED) {
            return $this->userRepo->onlyTrashed($perPage, $page);
        }
        return $this->userRepo->allUser($perPage, $page);
    }

    public function findUser($id)
    {
        return $this->userRepo->findUser($id);
    }

    public function updateUser($id, $data)
    {
        $data = $data->only([
            'name',
            'email',
            'phone',
            'img_id'
        ]);
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

    public function restoreUser($id)
    {
        $user = $this->userRepo->findUserDeleted($id);
        if (!$user) {
            return false;
        }

        $user->restore();
        return $user;
    }
}
