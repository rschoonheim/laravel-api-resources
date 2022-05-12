<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Models;

use Spatie\DataTransferObject\DataTransferObject;

class Route extends DataTransferObject
{
    public readonly array $methods;
    public readonly string $path;
    public readonly string $method;
}