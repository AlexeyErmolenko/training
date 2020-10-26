<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

/**
 * Horizon service provider.
 */
class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Use night mode theme by default.
        Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function () {
            return $this->app->environment('development');
        });
    }
}
