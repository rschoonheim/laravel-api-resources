<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Feature\Repositories;

use Illuminate\Support\Facades\Storage;
use Rschoonheim\LaravelApiResource\Models\Resource;
use Rschoonheim\LaravelApiResource\Repositories\ResourceRepository;
use Rschoonheim\LaravelApiResource\Tests\TestCase;

class ResourceRepositoryTest extends TestCase
{
    /** @test */
    public function service_container_can_create_instance_of_resource_repository(): void
    {
        $this->assertInstanceOf(
            ResourceRepository::class,
            app()->make(ResourceRepository::class)
        );
    }

    /** @test */
    public function get_returns_configuration_based_on_identifier(): void
    {
        Storage::fake();
        Storage::put('test.yaml', file_get_contents(
            __DIR__ . '/../../Fixtures/Configuration/Resource.yml'
        ));

        /** @var ResourceRepository $repository */
        $repository = app()->make(ResourceRepository::class);
        $result = $repository->get('test');

        $this->assertInstanceOf(
            Resource::class,
            $result
        );

        dd($result);
    }


}