<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Routing;

use Illuminate\Routing\Router;
use Illuminate\Support\Traits\Macroable;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourcePaginate;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Macros\ResourceIndexMacro;
use Rschoonheim\LaravelApiResource\Resource\Resource;
use Rschoonheim\LaravelApiResource\Resource\ResourceReader;
use Rschoonheim\LaravelApiResource\Tests\Fixtures\TestModel;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * class ResourceRegister.
 *
 * @package Rschoonheim\LaravelApiResource\Macros;
 */
class ResourceRegister
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
        $reader = new ResourceReader($resource);

        $model =  $reader->getEloquentModel();



        dd($reader);





        /**
         * Should an index resource be made?
         */
        $indexResource = $reflection->getAttributes(ResourceIndex::class);
        if (isset($indexResource[0])) {
            $indexResource = $indexResource[0];
            $arguments = $indexResource->getArguments();
            $arguments['eloquentModel'] = $model;
            $arguments['paginate'] = false;
            if (isset($reflection->getAttributes(ResourcePaginate::class)[0])) {
                $arguments['paginate'] = true;
            }

            $this->index($path, $arguments);
        }

        return $this;
    }

    /**
     * Registers an index resource to Laravel.
     *
     * @param string $path
     * @param array $options
     * @return \Rschoonheim\LaravelApiResource\Routing\ResourceRegister
     */
    public function index(string $path, array $options = []): self {
        Resource::macro(
            ResourceIndexMacro::getName(),
            ResourceIndexMacro::handler($options)
        );

        $this->router->get($path, [Resource::class, 'index']);

        return $this;
    }
}
