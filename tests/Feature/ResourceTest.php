<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Feature;

use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestModel;
use Rschoonheim\LaravelApiResource\Tests\TestCase;

/**
 * class ResourceTest.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Feature;
 */
class ResourceTest extends TestCase
{
    /** @test */
    public function index_returns_listing(): void
    {
        $model = TestModel::create();

        $response = $this->get('/resource/test');
        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $model->id,
                ]
            ]
        ]);
    }

    /** @test */
    public function show_returns_details(): void
    {
        $model = TestModel::create();
        $response = $this->get('/resource/test/' . $model->id);
        $response->assertOk();
        $response->assertJson([
            'data' => [
                123
            ],
        ]);
    }

}
