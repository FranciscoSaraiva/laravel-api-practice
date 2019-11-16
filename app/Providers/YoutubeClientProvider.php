<?php

namespace App\Providers;

use App\Services\YoutubeClient\YoutubeClient;
use App\Services\YoutubeClient\YoutubeClientInterface;
use Illuminate\Support\ServiceProvider;


class YoutubeClientProvider extends ServiceProvider
{
    /**
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
        $this->app->bind(YoutubeClientInterface::class, YoutubeClient::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            YoutubeClientInterface::class,
        ];
    }
}
