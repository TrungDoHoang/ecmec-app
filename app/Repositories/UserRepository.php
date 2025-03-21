<?php

namespace App\Repositories;

use App\Models\User;

// Repository class nhận dữ liệu từ service, thao tác với db(viết query) và trả về cho service
class UserRepository
{
    public function allUser()
    {
        return User::all();
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        return User::find($id)->update($data);
    }

    public function deleteUser($id)
    {
        return User::destroy($id);
    }
}
