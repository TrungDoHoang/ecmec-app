<?php

namespace App\Contracts;

interface UserServiceInterface
{
    public function getAllUser($folder);

    public function findUser($id);

    public function updateUser($id, array $data);

    public function deleteUser($id);

    public function restoreUser($id);
}
