<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lines\Arbi;

class ArbiServiceProvider extends ServiceProvider
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
        $this->app->bind('arbi', function () {
            return new Arbi();
        });
    }
}
