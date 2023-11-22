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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // modify token expiration time to 60 minutes
        Passport::tokensExpireIn(now()->addMinutes(60));

        // modify refresh token expiration time to 1 day
        Passport::refreshTokensExpireIn(now()->addDays(1));
    }
}
