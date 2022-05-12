<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Fixtures;

use Illuminate\Support\ServiceProvider;

/**
 * class TestingServiceProvider.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Fixtures
 */
class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register testing services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
