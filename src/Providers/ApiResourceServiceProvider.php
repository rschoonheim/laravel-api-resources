<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rschoonheim\LaravelApiResource\Exceptions\ResourcesConfigurationException;
use Rschoonheim\LaravelApiResource\Routing\ResourceRegister;

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
        \Illuminate\Routing\Route::macro('resources', function() {
            return new ResourceRegister(
                app()->make(Router::class)
            );
        });

        $this->loadResourceRoutes();

        $this->publishes([
            __DIR__ . '/../../assets/config/resources.php' => config_path('resources.php'),
            __DIR__ . '/../../assets/routes/resources.php' => base_path('routes/resources.php'),
        ]);
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
        Route::middleware('web')
            ->group($routeFilePath);
    }
}
