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
    public string $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }
}
