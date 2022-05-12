<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Unit\Resource;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Rschoonheim\LaravelApiResource\Resource\Models\DynamicResourceController;
use Rschoonheim\LaravelApiResource\Resource\Models\ResourceConfiguration;
use Rschoonheim\LaravelApiResource\Resource\ResourceBuilder;

class ResourceBuilderTest extends TestCase
{
    /** @test */
    public function php_can_create_instance_of_resource_builder(): void
    {
        $this->assertInstanceOf(
            ResourceBuilder::class,
            new ResourceBuilder(
                ResourceConfiguration::create([])
            )
        );
    }

    /** @test */
    public function resource_returns_instance_of_resource_builder(): void
    {
        $this->assertInstanceOf(
            ResourceBuilder::class,
            ResourceBuilder::resource(new class() {
            })
        );
    }

    /** @test */
    public function eloquent_returns_instance_of_resource_builder(): void
    {
        $this->assertInstanceOf(
            ResourceBuilder::class,
            ResourceBuilder::eloquent(new class() extends Model {
            })
        );
    }

    /** @test */
    public function result_returns_dynamic_resource_controller_when_building_based_of_resource(): void
    {
        $instance = ResourceBuilder::resource(new class() {
        });

        $this->assertInstanceOf(
            DynamicResourceController::class,
            $instance->result()
        );
    }

    /** @test */
    public function result_returns_dynamic_resource_controller_when_building_based_of_eloquent_model(): void
    {
        $instance = ResourceBuilder::eloquent(new class() extends Model {
        });

        $this->assertInstanceOf(
            DynamicResourceController::class,
            $instance->result()
        );
    }

}