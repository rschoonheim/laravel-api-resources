<?php declare(strict_types=1);

/** @var \Rschoonheim\LaravelApiResource\Routing\ResourceRegister $resources */
$resources = \Illuminate\Routing\Route::resources();


/**
 * The following example creates an index
 * resource accessible via /resources/test.
 */
$resources->load(
    '/resource/test',
    \Rschoonheim\LaravelApiResource\Tests\Fixtures\TestResource::class,
);
