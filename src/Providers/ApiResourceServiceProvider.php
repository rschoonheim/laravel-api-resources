<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Rschoonheim\LaravelApiResource\Exceptions\ResourcesConfigurationException;

/**
 * class ApiResourceServiceProvider.
 */
class ApiResourceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->publishes([
            __DIR__.'/../../assets/config/resources.php' => config_path('resources.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../assets/routes/resources.php' => base_path('routes/resources.php'),
        ]);

        $this->loadResourceRoutes();
    }

    private function loadResourceRoutes(): void
    {
        /**
         * Collect & Validate Configuration
         */
        $routeFilePath = config('resources.routes_file');
        if (!is_file($routeFilePath)) {
            throw new ResourcesConfigurationException(
                "Routes file $routeFilePath was not found."
            );
        }

        /**
         * Register routes.
         */
        Route::middleware('api')
            ->prefix('resource')
            ->group($routeFilePath);
    }
}
