<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Feature\Providers;

use Rschoonheim\LaravelApiResource\Exceptions\ResourcesConfigurationException;
use Rschoonheim\LaravelApiResource\Providers\ApiResourceServiceProvider;
use Rschoonheim\LaravelApiResource\Tests\TestCase;

/**
 * class ApiResourceServiceProviderTest.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Feature\Providers
 */
class ApiResourceServiceProviderTest extends TestCase
{
    /** @test */
    public function load_resource_routes_throws_resources_configuration_exception_when_route_file_was_not_found(): void
    {
        $routeFile = '/dev/null';
        $this->app['config']->set('resources.routes_file', $routeFile);

        $this->expectException(ResourcesConfigurationException::class);
        $this->expectExceptionMessage(
            "Routes file {$routeFile} was not found."
        );

        $provider = app()->makeWith(ApiResourceServiceProvider::class, [
            'app' => app()
        ]);
        $provider->register();
    }
}
