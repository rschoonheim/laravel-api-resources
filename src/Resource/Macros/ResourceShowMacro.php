<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Macros;

use Closure;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * class ResourceShowMacro.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Macros;
 */
class ResourceShowMacro
{
    /**
     * Returns the macro name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'show';
    }

    /**
     * Returns the macro handler closure.
     *
     * @param array $options
     * @return \Closure
     */
    public static function handler(array $options = []): Closure
    {
        return function(int $id) use ($options) {
            /** @var \Illuminate\Database\Eloquent\Model $eloquentModel */
            $eloquentModel = app()->make($options['eloquentModel']);
            return response()->json([
                'data' => $eloquentModel->where('id', $id)->firstOrFail(),
            ]);
        };
    }
}
