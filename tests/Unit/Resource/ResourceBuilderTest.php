<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Unit\Resource;

use PHPUnit\Framework\TestCase;
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
                ResourceConfiguration::create([
                    'persistence' => [],
                    'methods' => [],
                ])
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

}


