<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Enums\UserEnum;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthService implements AuthServiceInterface
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepo->createUser($data);
    }

    public function authenticate(array $data)
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();

            /**
             * Call API to get access token by password grant. Response is JSON 
             * {
             * "token_type": "Bearer",
             * "expires_in: 60",
             * "access_token": "xyz",
             * "refresh_token": "xyz"
             * } 
             * */
            $resAuth = Http::asForm()->post(env('APP_AUTH_URL') . '/oauth/token', [
                'grant_type' => 'password',
                // // tên_file.key
                'client_id' => config('auth.passport.password_grant_client.id'),
                'client_secret' => config('auth.passport.password_grant_client.secret'),
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => ''
            ]);

            return [
                'user' => new UserResource($user),
                'accessToken' => $resAuth['access_token'],
                'refreshToken' => $resAuth['refresh_token'],
                'expiresIn' => $resAuth['expires_in'],
            ];
        }
    }

    public function changePassword($id, array $data)
    {
        $user = $this->userRepo->findUser($id);
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

    public function logout()
    {
        $user = Auth::user();
        $this->userRepo->revokeToken($user);
        return 'Logout successfully';
    }

    public function logoutAllDevice()
    {
        $user = Auth::user();
        $this->userRepo->revokeAllTokens($user);
        return 'Logout all devices successfully';
    }

    public function refreshToken($refreshToken)
    {
        $newToken = Http::asForm()->post(env('APP_AUTH_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('auth.passport.password_grant_client.id'),
            'client_secret' => config('auth.passport.password_grant_client.secret'),
            'scope' => ''
        ]);

        if (!isset($newToken['error'])) {
            return [
                'accessAoken' => $newToken['access_token'],
                'refreshToken' => $newToken['refresh_token'],
                'expiresIn' => $newToken['expires_in'],
            ];
        }
    }

    public function me()
    {
        $currentUser = Auth::user();
        return $currentUser;
    }
}
