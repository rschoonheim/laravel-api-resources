<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Models\Casters;

use Rschoonheim\LaravelApiResource\Models\Route;
use Spatie\DataTransferObject\Caster;

class ResourceRoutesCaster implements Caster
{
    public function cast(mixed $value): array
    {
        $routes = [];
        foreach ($value as $route) {
            $args = explode(':', $route);

            /**
             * Get method & route path.
             */
            list($method, $path) = explode('@', $args[0]);

            $routes[] = new Route(
                methods: [strtoupper($method)],
                path: $path,
                method: $args[1]
            );
        }
        return $routes;
    }
}