<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Unit\Resource\Normalizers;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceDestroy;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceShow;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceStore;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceUpdate;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceAttributeDuplicationException;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Normalizers\ResourceNormalizer;

class ResourceNormalizerTest extends TestCase
{
    /** @test */
    public function php_can_create_instance_of_resource_normalizer(): void
    {
        $this->assertInstanceOf(
            ResourceNormalizer::class,
            new ResourceNormalizer()
        );
    }

    /** @test */
    public function normalize_returns_empty_array_when_no_details_are_found(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new class() {
            }
        );

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /** @test */
    public function normalize_throws_attribute_duplication_exception_when_an_attribute_is_duplicated(): void
    {
        $this->expectException(
            ResourceAttributeDuplicationException::class
        );
        $this->expectDeprecationMessage(
            " was defined multiple times on resource."
        );

        $normalizer = new ResourceNormalizer();
        $normalizer->normalize(new ResourceWithDuplicatedAttributes());
    }

    /** @test */
    public function normalize_returns_data_model_when_it_is_defined_on_resource(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(new ResourceWithResourceModel());

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ]
        ], $result);
    }

    /** @test */
    public function normalize_throws_resource_model_undefined_when_normalizing_index_when_no_resource_model_is_defined(): void
    {
        $this->expectException(
            ResourceConfigurationException::class
        );
        $this->expectExceptionMessage(
            "Could not define resource index without resource model."
        );

        $normalizer = new ResourceNormalizer();
        $normalizer->normalize(new ResourceWithIndexWithoutResourceModel());
    }

    /** @test */
    public function normalize_returns_configuration_with_index_when_resource_model_is_defined(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new ResourceWithIndexAndResourceModel()
        );

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ],
            'methods' => [
                [
                    'method' => 'index',
                    'arguments' => [
                        'filterable' => [],
                        'sortable' => [],
                        'includedRelationships' => [],
                        'selectableFields' => [],
                    ]
                ]
            ]
        ], $result);
    }

    /** @test */
    public function normalize_returns_configuration_with_show_when_resource_model_is_defined(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new ResourceWithShowAndResourceModel()
        );

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ],
            'methods' => [
                [
                    'method' => 'show',
                    'arguments' => [
                        'primary' => 'id'
                    ]
                ]
            ]
        ], $result);
    }

    /** @test */
    public function normalize_returns_configuration_with_store_when_resource_model_is_defined(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new ResourceWithResourceModelAndResourceStore()
        );

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ],
            'methods' => [
                [
                    'method' => 'store',
                    'arguments' => [
                        'request' => 'example',
                        'persister' => 'example'
                    ]
                ]
            ]
        ], $result);
    }

    /** @test */
    public function normalize_returns_configuration_with_update_when_resource_model_is_defined(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new ResourceWithResourceModelAndResourceUpdate()
        );

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ],
            'methods' => [
                [
                    'method' => 'update',
                    'arguments' => [
                        'request' => 'example',
                        'persister' => 'example'
                    ]
                ]
            ]
        ], $result);
    }

    /** @test */
    public function normalize_returns_configuration_with_destroy_when_resource_model_is_defined(): void
    {
        $normalizer = new ResourceNormalizer();
        $result = $normalizer->normalize(
            new ResourceWithDestroyAndResourceModel()
        );

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals([
            'persistence' => [
                [
                    'type' => 'source',
                    'driver' => 'eloquent',
                    'object' => FakeResourceModel::class,
                ]
            ],
            'methods' => [
                [
                    'method' => 'destroy',
                    'arguments' => [
                        'primary' => 'id',
                    ]
                ]
            ]
        ], $result);
    }
}

#[
    ResourceModel(
        namespace: FakeResourceModel::class,
        driver: 'eloquent'
    ),
    ResourceDestroy(primary: 'id')
]
class ResourceWithDestroyAndResourceModel
{
}

#[
    ResourceModel(
        namespace: FakeResourceModel::class,
        driver: 'eloquent'
    ),
    ResourceUpdate(request: 'example', persister: 'example')
]
class ResourceWithResourceModelAndResourceUpdate
{
}

#[
    ResourceModel(
        namespace: FakeResourceModel::class,
        driver: 'eloquent'
    ),
    ResourceStore(request: 'example', persister: 'example')
]
class ResourceWithResourceModelAndResourceStore
{
}

#[
    ResourceModel(
        namespace: FakeResourceModel::class,
        driver: 'eloquent'
    ),
    ResourceShow(primary: 'id')
]
class ResourceWithShowAndResourceModel
{
}

#[
    ResourceModel(
        namespace: FakeResourceModel::class,
        driver: 'eloquent'
    ),
    ResourceIndex(
        filterable: [],
        sortable: [],
        includedRelationships: [],
        selectableFields: []
    )
]
class ResourceWithIndexAndResourceModel
{
}

#[ResourceIndex(
    filterable: [],
    sortable: [],
    includedRelationships: [],
    selectableFields: []
)]
class ResourceWithIndexWithoutResourceModel
{
}

#[ResourceModel(namespace: FakeResourceModel::class, driver: 'eloquent')]
class ResourceWithResourceModel
{
}

#[
    ResourceModel(namespace: FakeResourceModel::class, driver: 'eloquent'),
    ResourceModel(namespace: FakeResourceModel::class, driver: 'eloquent'),
]
class ResourceWithDuplicatedAttributes
{
}

class FakeResourceModel extends Model
{
}