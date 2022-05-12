<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Attributes;

use Attribute;

/**
 * class ResourceUpdate.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Attributes;
 */
#[Attribute]
class ResourceUpdate
{
    public readonly string $request;
    public readonly string $persister;
    public function __construct(string $request, string $persister)
    {
        $this->request = $request;
        $this->persister = $persister;
    }

}
