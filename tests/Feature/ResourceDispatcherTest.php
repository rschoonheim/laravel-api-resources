<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Feature;

use Rschoonheim\LaravelApiResource\Tests\TestCase;

/**
 * class ResourceDispatcherTest.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Feature
 */
class ResourceDispatcherTest extends TestCase
{
    /** @test */
    public function dispatch_executes_given_route(): void
    {
        $response = $this->get('/resource/test');
        $response->assertOk();
    }
}
