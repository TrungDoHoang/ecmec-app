<?php

namespace App\Contracts;

interface AuthServiceInterface
{
    public function register(array $data);

    public function authenticate(array $data);

    public function logout();

    public function logoutAllDevice();

    public function refreshToken(string $refreshToken);

    public function me();

    public function verifyTokenRegister(string $token);

    public function resendMailRegister(string $email);
}
