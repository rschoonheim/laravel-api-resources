<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Rschoonheim\LaravelApiResource\Providers\ApiResourceServiceProvider;
use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestingServiceProvider;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

/**
 * class TestCase.
 *
 * @package Rschoonheim\LaravelApiResource\Tests;
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

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
            TestingServiceProvider::class,
            QueryBuilderServiceProvider::class,
            ApiResourceServiceProvider::class,
        ];
    }
}
