<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Models;

use Rschoonheim\LaravelApiResource\Models\Casters\ResourceMethodsCaster;
use Rschoonheim\LaravelApiResource\Models\Casters\ResourceRoutesCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Resource configuration.
 *
 * @author Romano Schoonheim <romano@romanoschoonheim.nl>
 * @website https://stal.digital/
 */
class Resource extends DataTransferObject
{
    public readonly string $identifier;

    public readonly string $location;

    public readonly string $name;

    #[CastWith(ResourceRoutesCaster::class)]
    public readonly array $routes;

    #[CastWith(ResourceMethodsCaster::class)]
    public readonly array $methods;
}