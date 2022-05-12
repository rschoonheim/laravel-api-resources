<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Attributes;

use Attribute;

/**
 * class ResourceModel.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Attributes;
 */
#[Attribute]
class ResourceModel
{
    public readonly string $namespace;

    public readonly string $driver;

    public function __construct(string $namespace, string $driver)
    {
        $this->namespace = $namespace;
        $this->driver = $driver;
    }
}
