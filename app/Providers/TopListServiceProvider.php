<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\TopList;

class TopListServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\TopList', function ($app) {
            return new TopList();
        });
    }
}
