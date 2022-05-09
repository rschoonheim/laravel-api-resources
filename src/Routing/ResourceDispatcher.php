<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Routing;

use Illuminate\Routing\Router;
use Illuminate\Support\Traits\Macroable;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Resource;
use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestModel;

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


        $this->index($path, $model);

        return $this;
    }

    /**
     * Registers an index resource to Laravel.
     *
     * @return void
     */
    public function index(string $path, string $eloquentModel): self
    {
        Resource::macro('index', function() use ($eloquentModel) {
            $model = app()->make($eloquentModel);
            return response()->json([
                'data' => $model->all()
            ]);
        });

        $this->router->get($path, [Resource::class, 'index']);

        return $this;
    }
}
