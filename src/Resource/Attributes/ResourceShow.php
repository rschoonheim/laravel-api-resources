<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Attributes;

use Attribute;

/**
 * class ResourceShow.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Attributes;
 */
#[Attribute]
class ResourceShow
{
    public readonly string|int $primary;
    public function __construct(int|string $primary)
    {
        $this->primary = $primary;
    }

}
