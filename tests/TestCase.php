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
     * Returns an array containing service providers for
     * the package.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ApiResourceServiceProvider::class,
        ];
    }
}
