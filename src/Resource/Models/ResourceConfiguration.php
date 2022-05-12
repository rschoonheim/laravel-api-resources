<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Models;

class ResourceConfiguration
{
    public static function create(array $configuration): self
    {
        return new self($configuration);
    }
}