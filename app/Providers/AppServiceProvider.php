<?php

namespace App\Providers;

use App\Storage\DbUserRepository;
use App\Storage\Interfaces\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(UserRepository::class, DbUserRepository::class);
    }
}
