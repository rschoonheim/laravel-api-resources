<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Attributes;

use Attribute;

/**
 * class ResourceDestroy.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Attributes;
 */
#[Attribute]
class ResourceDestroy
{
    public readonly string|int $primary;
    public function __construct(int|string $primary)
    {
        $this->primary = $primary;
    }
}
