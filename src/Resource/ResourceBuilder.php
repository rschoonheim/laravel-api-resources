<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource;

use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Macros\DestroyMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\IndexMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\ShowMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\StoreMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\UpdateMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Models\DynamicResourceController;
use Rschoonheim\LaravelApiResource\Resource\Models\ResourceConfiguration;
use Rschoonheim\LaravelApiResource\Resource\Normalizers\EloquentNormalizer;
use Rschoonheim\LaravelApiResource\Resource\Normalizers\ResourceNormalizer;

/**
 * class ResourceBuilder.
 *
 * @author Romano Schoonheim <romano@romanoschoonheim.nl>
 * @website https://www.stal.digital/
 */
class ResourceBuilder
{
    private readonly ResourceConfiguration $configuration;

    public function __construct(ResourceConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Create a resource builder based on a resource object.
     *
     * @param object $resource
     * @return static
     * @throws Exceptions\ResourceConfigurationException
     */
    public static function resource(object $resource): self
    {
        /**
         * Normalize resource object.
         */
        $resourceNormalizer = new ResourceNormalizer();
        $configuration = $resourceNormalizer->normalize($resource);

        return new self(
            ResourceConfiguration::create($configuration)
        );
    }

    /**
     * Create a resource builder based on an eloquent model.
     *
     * @param object $model
     * @return static
     */
    public static function eloquent(object $model): self
    {
        /**
         * Normalize eloquent object.
         */
        $eloquentNormalizer = new EloquentNormalizer();
        $configuration = $eloquentNormalizer->normalize($model);

        return new self(
            ResourceConfiguration::create($configuration)
        );
    }

    /**
     * Returns a freshly instantiated dynamic resource controller based on builder state.
     *
     * @return DynamicResourceController
     * @throws ResourceConfigurationException
     */
    public function result(): DynamicResourceController
    {
        $controller = new DynamicResourceController();

        // Bind methods.
        foreach ($this->configuration->methods as $name => $arguments) {

            $handler = match ($name) {
                'index' => IndexMacroHandler::class,
                'show' => ShowMacroHandler::class,
                'store' => StoreMacroHandler::class,
                'update' => UpdateMacroHandler::class,
                'destroy' => DestroyMacroHandler::class,
                default => null,
            };

            if (is_null($handler)) {
                throw new ResourceConfigurationException(
                    "Could not find a handler for method: {$name}"
                );
            }

            $controller::macro($name, $handler::handle($this->configuration, $arguments));
        }

        return $controller;
    }

}