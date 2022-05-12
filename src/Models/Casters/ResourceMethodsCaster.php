<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Models\Casters;

use Rschoonheim\LaravelApiResource\Models\Method;
use Spatie\DataTransferObject\Caster;

class ResourceMethodsCaster implements Caster
{
    public function cast(mixed $value): array
    {
        $methods = [];
        foreach ($value as $method => $arguments) {
            $methods[$method] = new Method();
        }
        return $methods;
    }
}