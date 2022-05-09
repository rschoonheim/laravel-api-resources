<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests;

use Illuminate\Foundation\Application;
use Rschoonheim\LaravelApiResource\Providers\ApiResourceServiceProvider;

/**
 * class TestCase.
 *
 * @package Rschoonheim\LaravelApiResource\Tests;
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Appends package configurations to application configurations.
     *
     * @param $app
     * @return void
     */
    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('resources.routes_file', __DIR__ . '/../assets/routes/resources.php');
    }

    /**
     * Returns an array containing service providers for
     * the package.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            ApiResourceServiceProvider::class,
        ];
    }
}
