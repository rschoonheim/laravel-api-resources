<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource\Models;

use Illuminate\Support\Traits\Macroable;

/**
 * class DynamicResourceController.
 *
 * The methods on this controller gets bound dynamically
 * using Laravel's macros.
 *
 * Creation of instances is handles by `\Rschoonheim\LaravelApiResource\Resource\ResourceBuilder::class`
 */
class DynamicResourceController
{
    use Macroable {
        __call as macroCall;
    }
}