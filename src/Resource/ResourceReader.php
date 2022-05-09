<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource;

use ReflectionClass;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;

/**
 * class ResourceReader.
 *
 * @package Rschoonheim\LaravelApiResource\Resource;
 */
class ResourceReader
{
    private readonly ReflectionClass $reflectionClass;

    public function __construct(string $namespace)
    {
        $this->reflectionClass = new ReflectionClass($namespace);
    }

    /**
     * Returns the Eloquent model for resource.
     *
     * @return string
     * @throws \Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException
     */
    public function getEloquentModel(): string
    {
        $modelAttribute = $this->reflectionClass->getAttributes(ResourceModel::class);
        if (empty($modelAttribute)) {
            throw new ResourceConfigurationException('Could not find ' . ResourceModel::class . ' attribute.');
        }

        if (count($modelAttribute) > 1) {
            throw new ResourceConfigurationException(
                'Too many ' . ResourceModel::class . ' attributes found. Max 1'
            );
        }
        return $modelAttribute[0]->getArguments()['namespace'];
    }
}
