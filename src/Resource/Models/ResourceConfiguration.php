<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Models;

class ResourceConfiguration
{
    /**
     * Name of source driver.
     *
     * @var string|mixed
     */
    public readonly string $sourceDriver;

    /**
     * Namespace of object responsible for fetching data.
     *
     * @var string|mixed
     */
    public readonly string $sourceObject;

    /**
     * Set of methods for resource.
     *
     * @var array
     */
    public readonly array $methods;

    public function __construct(array $configuration)
    {
        foreach ($configuration['persistence'] as $persistence) {
            if ($persistence['type'] === 'source') {
                $this->sourceDriver = $persistence['driver'];
                $this->sourceObject = $persistence['object'];
            }
        }

        foreach ($configuration['methods'] as $method) {
            $this->methods[$method['method']] = $method['arguments'];
        }
    }

    public static function create(array $configuration): self
    {
        return new self($configuration);
    }
}