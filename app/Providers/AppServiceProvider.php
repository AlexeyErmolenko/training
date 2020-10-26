<?php

namespace App\Providers;

use App\Exceptions\ApiExceptionHandler;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

/**
 * Provider with specific for this application settings.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            URL::forceRootUrl(config('app.url'));
        }
        $this->app->singleton('app.api.exception', ApiExceptionHandler::class);
    }
}
