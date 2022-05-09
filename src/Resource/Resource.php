<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Resource;

use Illuminate\Support\Traits\Macroable;

/**
 * class Resource.
 *
 * @package Rschoonheim\LaravelApiResource\Resource;
 */
class Resource
{
    use Macroable {
        __call as macroCall;
    }
}
