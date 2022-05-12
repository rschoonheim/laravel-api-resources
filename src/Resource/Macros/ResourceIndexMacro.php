<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Macros;

use Closure;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * class ResourceIndexMacro.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Macros;
 */
class ResourceIndexMacro
{
    /**
     * Returns the macro name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'index';
    }

    /**
     * Returns the macro handler closure.
     *
     * @param array $options
     * @return \Closure
     */
    public static function handler(array $options = []): Closure
    {
        return function() use ($options) {
            $model = QueryBuilder::for($options['eloquentModel'])
                ->allowedFields($options['selectableFields'])
                ->allowedFilters($options['filterable'])
                ->allowedSorts($options['sortable'])
                ->allowedIncludes($options['includedRelationships']);

            if ($options['paginate']) {
                $model->paginate()->appends(request()->query());
            }

            return response()->json([
                'data' => $model->get()->all()
            ]);
        };
    }
}
