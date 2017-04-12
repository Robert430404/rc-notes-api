<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * This is the middleware that verifies all incoming connections to
     * protected controllers/routes. In this case, we are using an API
     * key embedded in a request header.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('api_key')) {
                return User::where('api_key', $request->header('api_key'))->first();
            }
        });
    }
}
