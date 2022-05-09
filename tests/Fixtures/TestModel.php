<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * class TestModel.
 *
 * @package Rschoonheim\LaravelApiResource\Tests\Fixtures
 */
class TestModel extends Model
{
    protected $fillable = ['name'];
}
