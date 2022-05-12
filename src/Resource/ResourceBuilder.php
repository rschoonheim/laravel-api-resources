<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource;

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
     */
    public function result(): DynamicResourceController
    {
        return new DynamicResourceController();
    }

}