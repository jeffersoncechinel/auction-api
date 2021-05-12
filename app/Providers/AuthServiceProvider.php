<?php

namespace App\Providers;

use App\Extensions\DummyGuard;
use App\Extensions\DummyUserProvider;
use Illuminate\Container\Container;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // add custom guard provider
        Auth::provider('dummy', function ($app, array $config) {
            return new DummyUserProvider($app->make('App\Models\Auth\User'));
        });

        Auth::extend('dummy', function (Container $app, $name, array $config) {
            return new DummyGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });

        $this->registerPolicies();
    }
}
