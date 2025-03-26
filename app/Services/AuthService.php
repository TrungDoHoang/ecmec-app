<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Enums\UserEnum;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

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
            $user->makeHidden(['email_verified_at', 'password',]);
            $accessToken = $user->createToken('auth_token')->accessToken;
            $expiresAt = now()->add(Passport::tokensExpireIn());
            $formattedDate = $expiresAt->format('Y-m-d H:i:s');

            return [
                'user' => $user,
                'access_token' => $accessToken,
                'expiresIn' => $formattedDate
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

    public function refreshToken()
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->token()->id)->delete();
        $newToken = $user->createToken('auth_token')->accessToken;
        return $newToken;
    }

    public function me()
    {
        $currentUser = Auth::user();
        return $currentUser;
    }
}
