<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Routing;

use Illuminate\Routing\Router;
use Illuminate\Support\Traits\Macroable;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Resource;
use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestModel;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * class ResourcesMacro.
 *
 * @package Rschoonheim\LaravelApiResource\Macros;
 */
class ResourceDispatcher
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register a resource object.
     *
     * @param string $path
     * @param string $resource
     * @return $this
     * @throws \ReflectionException
     * @throws \Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException
     */
    public function load(string $path, string $resource): self
    {
        $reflection = new \ReflectionClass($resource);

        /**
         * Get resource model.
         */
        $modelAttribute = $reflection->getAttributes(ResourceModel::class);
        if (empty($modelAttribute)) {
            throw new ResourceConfigurationException('Could not find ' . ResourceModel::class . ' attribute.');
        }
        if (count($modelAttribute) > 1) {
            throw new ResourceConfigurationException(
                'Too many ' . ResourceModel::class . ' attributes found. Max 1'
            );
        }
        $model = $modelAttribute[0]->getArguments()['namespace'];

        /**
         * Should an index resource be made?
         */
        $indexResource = $reflection->getAttributes(ResourceIndex::class);
        if (isset($indexResource[0])) {
            $indexResource = $indexResource[0];
            $arguments = $indexResource->getArguments();
            $arguments['eloquentModel'] = $model;

            $this->index($path, $arguments);
        }

        return $this;
    }

    /**
     * Registers an index resource to Laravel.
     *
     * @param string $path
     * @param array $options
     * @return \Rschoonheim\LaravelApiResource\Routing\ResourceDispatcher
     */
    public function index(string $path, array $options = []): self {
        Resource::macro('index', function() use ($options) {
            $model = QueryBuilder::for($options['eloquentModel'])
                ->allowedFields($options['selectableFields'])
                ->allowedFilters($options['filterable'])
                ->allowedSorts($options['sortable'])
                ->allowedIncludes($options['includedRelationships']);

            return response()->json([
                'data' => $model->get()->all()
            ]);
        });

        $this->router->get($path, [Resource::class, 'index']);

        return $this;
    }
}
