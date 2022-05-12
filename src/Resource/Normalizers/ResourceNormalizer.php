<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Normalizers;

use ReflectionAttribute;
use ReflectionClass;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceDestroy;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceIndex;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceModel;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceShow;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceStore;
use Rschoonheim\LaravelApiResource\Resource\Attributes\ResourceUpdate;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceAttributeDuplicationException;
use Rschoonheim\LaravelApiResource\Resource\Exceptions\ResourceConfigurationException;
use Rschoonheim\LaravelApiResource\Resource\Macros\DestroyMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\IndexMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\ShowMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\StoreMacroHandler;
use Rschoonheim\LaravelApiResource\Resource\Macros\UpdateMacroHandler;

class ResourceNormalizer
{
    private array $normalizedForm = [
        'persistence' => [],
        'methods' => [],
    ];

    private ReflectionClass $resource;

    /**
     * Returns resource in its normalized form.
     *
     * @param object $resource
     * @return array
     * @throws ResourceConfigurationException
     */
    public function normalize(object $resource): array
    {
        $this->resource = new ReflectionClass($resource);

        /**
         * Normalize data source of resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceModel::class)) {
            $attribute = $this->getAttributeArguments(ResourceModel::class);
            $this->normalizedForm['persistence'][] = [
              'type' => 'source',
              'driver' => $attribute['driver'],
              'object' => $attribute['namespace']
            ];
        }

        /**
         * Normalize index for resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceIndex::class)) {
            $this->resourceHasResourceModel('index');
            $this->defineMethod(
                'index',
                IndexMacroHandler::class,
                $this->getAttributeArguments(ResourceIndex::class)
            );
        }

        /**
         * Normalize show for resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceShow::class)) {
            $this->resourceHasResourceModel('show');
            $this->defineMethod(
                'show',
                ShowMacroHandler::class,
                $this->getAttributeArguments(ResourceShow::class)
            );
        }

        /**
         * Normalize store for resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceStore::class)) {
            $this->resourceHasResourceModel('store');
            $this->defineMethod(
                'store',
                StoreMacroHandler::class,
                $this->getAttributeArguments(ResourceStore::class)
            );
        }

        /**
         * Normalize update for resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceUpdate::class)) {
            $this->resourceHasResourceModel('update');
            $this->defineMethod(
                'update',
                UpdateMacroHandler::class,
                $this->getAttributeArguments(ResourceUpdate::class)
            );
        }

        /**
         * Normalize destroy for resource.
         *
         */
        if ($this->resourceHasAttribute(ResourceDestroy::class)) {
            $this->resourceHasResourceModel('destroy');
            $this->defineMethod(
                'destroy',
                DestroyMacroHandler::class,
                $this->getAttributeArguments(ResourceDestroy::class)
            );
        }


        return $this->normalizedForm;
    }

    private function defineMethod(string $method, string $handler, array $arguments): void
    {
        if (!array_key_exists('methods', $this->normalizedForm)) {
            $this->normalizedForm['methods'] = [];
        }

        $this->normalizedForm['methods'][] = [
            'method' => $method,
            'arguments' => $arguments
        ];
    }

    private function resourceHasResourceModel(string $method): void
    {
        if (!$this->resourceHasAttribute(ResourceModel::class)) {
            throw new ResourceConfigurationException(
                "Could not define resource {$method} without resource model."
            );
        }
    }

    private function getAttributeArguments(string $attributeNamespace)
    {
        $attribute = $this->resourceGetAttribute($attributeNamespace);
        return $attribute->getArguments();
    }

    private function resourceGetAttribute(string $attributeNamespace): ReflectionAttribute
    {
        $attributes = $this->resource->getAttributes($attributeNamespace);
        if (count($attributes) > 1) {
            throw new ResourceAttributeDuplicationException(
                "$attributeNamespace was defined multiple times on resource."
            );
        }

        return $attributes[0];
    }

    private function resourceHasAttribute(string $attributeNamespace): bool
    {
        return !empty(
            $this->resource->getAttributes($attributeNamespace)
        );
    }
}