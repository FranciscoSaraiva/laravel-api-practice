<?php

namespace App\Providers;

use App\Services\YoutubeService\YoutubeService;
use App\Services\YoutubeService\YoutubeServiceInterface;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YoutubeServiceInterface::class, YoutubeService::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            YoutubeServiceInterface::class,
        ];
    }

}
