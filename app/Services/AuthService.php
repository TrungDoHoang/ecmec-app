<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Enums\UserEnum;
use App\Http\Resources\UserResource;
use App\Mail\VerifyEmailMail;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $data['email_verify_token'] = Str::random(60);
        $data['email_verify_token_expires'] = now()->addDays(7);

        $user = $this->userRepo->createUser($data);

        // Gửi email verify
        if ($user) {
            // $verifyUrl = env('FRONTEND_URL') . '/verify-email?token=' . $data['email_verify_token'];
            // Mail::to($user->email)->send(new VerifyEmailMail($verifyUrl));
            sendVerifyRegisterEmail($user->email_verify_token, $user->email);
        }

        return $user;
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

    public function verifyTokenRegister(string $token)
    {
        $user = $this->userRepo->findUser($token, 'email_verify_token');

        $user->update([
            'email_verified_at' => now(),
            'email_verify_token' => null, // Token chỉ dùng 1 lần
            'email_verify_token_expires' => null
        ]);

        return $user;
    }

    public function resendMailRegister(string $email)
    {
        $user = $this->userRepo->findUser($email, 'email');

        if (!$user) {
            return [
                'message' => 'User not found',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }

        if ($user->email_verified_at) {
            return [
                'message' => 'Email already verified',
                'code' => Response::HTTP_BAD_REQUEST
            ];
        }

        // Tạo token mới
        $user->update([
            'email_verify_token' => Str::random(60)
        ]);

        // Gửi lại email
        sendVerifyRegisterEmail($user->email_verify_token, $user->email);

        return [
            'message' => 'Verification email resent',
            'code' => Response::HTTP_OK
        ];
    }
}
