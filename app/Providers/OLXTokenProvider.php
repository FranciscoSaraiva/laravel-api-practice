<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OLXTokenProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OlxTokenServiceInterface::class, OlxTokenService::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            OlxTokenServiceInterface::class,
        ];
    }
}
