<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Fixtures;

use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;

/**
 * class TestResource.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Fixtures;
 */
#[ResourceModel(namespace: TestModel::class)]
class TestResource
{

}
