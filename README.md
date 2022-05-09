# Laravel API Resources

This package comes with tools to speed-up development of api resources without sacrificing quality.

**Features**

* Command to generate a resource,
* Attributes to create resources,

## Installing this package

Installing this package is done by running the following command.

```bash
composer require rschoonheim/laravel-api-resource
```

## Creating basic API resource
Every basic API resource comes with behavior that is required in most modern applications. The following example shows how to implement basic api resources.

```php
<?php declare(strict_types=1);

/**
 * Please make sure to use `\Illuminate\Routing\Route::resources()`.
 * This package doesn't work via the route facade (currently).
 * 
 * @var \Rschoonheim\LaravelApiResource\Routing\ResourceDispatcher $resources 
 */
$resources = \Illuminate\Routing\Route::resources();

// Create a basic index resource.
$resources->index(
    '/resource/user', 
    App\Models\User::class
);

// Create a basic show resource
$resources->show(
    '/resource/user/{id}', 
    App\Models\User::class
);

// Create a basic store resource
$resources->store(
    '/resource/user', 
    App\Models\User::class
);

// Create a basic update resource
$resources->update(
    '/resource/user', 
    App\Models\User::class
);

// Create a basic destroy resource
$resources->destroy(
    '/resource/user', 
    App\Models\User::class
);
```

## Creating advanced API resources
Not every use case can be handled by basic resources. Laravel api resources comes with a more advanced method of implementing resources. 

**Work in progres..**
