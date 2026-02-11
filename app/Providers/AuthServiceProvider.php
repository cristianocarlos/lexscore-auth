<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
        // Override the default eloquent provider
        Auth::provider('md5-eloquent', function ($app, array $config) {
            return new Md5EloquentUserProvider($app['hash'], $config['model']);
        });
    }
}
