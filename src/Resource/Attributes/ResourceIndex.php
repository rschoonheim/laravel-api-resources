<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Attributes;

use Attribute;

/**
 * class ResourceIndex.
 *
 * @package Rschoonheim\LaravelApiResource\Resource\Attributes;
 */
#[Attribute]
class ResourceIndex
{
    /**
     * An array containing filterable column names.
     *
     * @var array
     */
    public readonly array $filterable;

    /**
     * An array containing sortable column names.
     *
     * @var array
     */
    public readonly array $sortable;

    /**
     * An array containing included relationships.
     *
     * @var array
     */
    public readonly array $includedRelations;

    /**
     * An array selectable fields.
     *
     * @var array
     */
    public readonly array $allowedFields;

    public function __construct(
        array $filterable,
        array $sortable,
        array $includedRelationships,
        array $selectableFields
    ) {
        $this->filterable = $filterable;
        $this->sortable = $sortable;
        $this->includedRelations = $includedRelationships;
        $this->allowedFields = $selectableFields;
    }
}
