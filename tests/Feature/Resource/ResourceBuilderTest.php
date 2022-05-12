<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Feature\Resource;

use Illuminate\Http\JsonResponse;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\ResourceBuilder;
use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestModel;
use Rschoonheim\LaravelApiResource\Tests\TestCase;

class ResourceBuilderTest extends TestCase
{
    /** @test */
    public function when_resource_has_a_index_result_returns_dynamic_resource_controller_with_index_method(): void
    {
        $testModel = TestModel::create();

        $controller = ResourceBuilder::resource(
            new ResourceWithIndex()
        )->result();

        $this->assertTrue($controller::hasMacro('index'));

        $result = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(json_encode([
            'data' => [
                [
                    'id' => $testModel->id,
                    'created_at' => $testModel->created_at,
                    'updated_at' => $testModel->updated_at,
                ]
            ],
        ]), $result->content());
    }

}

#[
    ResourceModel(namespace: TestModel::class, driver: 'eloquent'),
    ResourceIndex(
        filterable: [],
        sortable: [],
        includedRelationships: [],
        selectableFields: []
    )
]
class ResourceWithIndex {}



