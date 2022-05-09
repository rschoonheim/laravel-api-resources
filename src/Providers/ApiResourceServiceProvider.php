<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Rschoonheim\LaravelApiResource\Exceptions\ResourcesConfigurationException;

/**
 * class ApiResourceServiceProvider.
 *
 * @package Rschoonheim\LaravelApiResource\Providers
 */
class ApiResourceServiceProvider extends ServiceProvider
{
    /**
     * Registers api resource services to Laravels container.
     *
     * @return void
     * @throws ResourcesConfigurationException
     */
    public function register(): void
    {
        $this->publishes([
            __DIR__ . '/../../assets/config/resources.php' => config_path('resources.php'),
            __DIR__ . '/../../assets/routes/resources.php' => base_path('routes/resources.php'),
        ]);

        $this->loadResourceRoutes();
    }

    /**
     * Loads resource routes into Laravels routing.
     *
     * @return void
     * @throws ResourcesConfigurationException
     */
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
