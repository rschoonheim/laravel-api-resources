<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Macros;

use Rschoonheim\LaravelApiResource\Resource\Models\ResourceConfiguration;
use Spatie\QueryBuilder\QueryBuilder;

class IndexMacroHandler
{
    public static function handle(ResourceConfiguration $configuration, array $arguments)
    {
        return function () use ($configuration, $arguments) {
            $model = QueryBuilder::for($configuration->sourceObject)
                ->allowedFields($arguments['selectableFields'])
                ->allowedFilters($arguments['filterable'])
                ->allowedSorts($arguments['sortable'])
                ->allowedIncludes($arguments['includedRelationships']);

            return response()->json([
                'data' => $model->get()->all()
            ]);
        };
    }
}