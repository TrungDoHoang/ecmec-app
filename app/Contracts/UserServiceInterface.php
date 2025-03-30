<?php

namespace App\Contracts;

interface UserServiceInterface
{
    public function getAllUser(string $folder, int $perPage, int $page);

    public function findUser($id);

    public function updateUser($id, array $data);

    public function deleteUser($id);

    public function restoreUser($id);
}
