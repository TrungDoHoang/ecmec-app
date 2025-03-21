<?php

namespace App\Contracts;

interface UserServiceInterface
{
    public function getAllUser();

    public function findUser($id);

    public function createUser(array $data);

    public function updateUser($id, array $data);

    public function deleteUser($id);
}
