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
        // Thiết lập thời gian hết hạn cho access token (ví dụ 1 giờ)
        Passport::tokensExpireIn(now()->addMinutes(30));

        // Thiết lập thời gian hết hạn cho refresh token (ví dụ 30 ngày)
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
