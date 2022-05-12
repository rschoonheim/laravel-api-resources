<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Unit\Resource\Models;

use PHPUnit\Framework\TestCase;
use Rschoonheim\LaravelApiResource\Resource\Models\DynamicResourceController;

/**
 * class DynamicResourceControllerTest.
 */
class DynamicResourceControllerTest extends TestCase
{
    /** @test */
    public function php_can_create_instance_of_dynamic_resource_controller(): void
    {
        $this->assertInstanceOf(
            DynamicResourceController::class,
            new DynamicResourceController()
        );
    }

    /** @test */
    public function macro_can_be_created_on_object(): void
    {
        $methodName = 'test';
        $returnValue = 'test-value';

        // Create macro method.
        $instance = new DynamicResourceController();
        $instance::macro($methodName, function() use ($returnValue): string {
            return $returnValue;
        });

        $result = $instance->{$methodName}();
        $this->assertEquals($returnValue, $result);
    }
}