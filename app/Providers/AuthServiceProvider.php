<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $accessTokenExpireIn = now()->addMinutes(30); // Access token hết hạn sau 1 ph
        $refreshTokenExpireIn = now()->addHours(1); // Refresh token hết hạn sau 1h
        // Tùy chọn: Đặt thời gian hết hạn cho tokens
        Passport::tokensExpireIn($accessTokenExpireIn);
        Passport::refreshTokensExpireIn($refreshTokenExpireIn);
        Passport::personalAccessTokensExpireIn($accessTokenExpireIn);
    }
}
