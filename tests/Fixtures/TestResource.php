<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Fixtures;

use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourcePaginate;

/**
 * class TestResource.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Fixtures;
 */
#[
    ResourceModel(namespace: TestModel::class),
    ResourcePaginate(),
    ResourceIndex(
        filterable: [],
        sortable: [],
        includedRelationships: [],
        selectableFields: []
    )
]
class TestResource
{

}
