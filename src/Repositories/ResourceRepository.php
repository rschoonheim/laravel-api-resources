<?php declare(strict_types=1);

namespace Rschoonheim\LaravelApiResource\Repositories;

use Illuminate\Support\Facades\Storage;
use Rschoonheim\LaravelApiResource\Models\Resource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\Yaml\Yaml;

class ResourceRepository
{
    /**
     * Fetches resource based on identifier.
     *
     * @param string $identifier
     * @return Resource
     * @throws UnknownProperties
     */
    public function get(string $identifier): Resource
    {
        $dataString = Storage::get($identifier . '.yaml');
        if (!$dataString) {
            dd("Not found..");
        }
        $data = Yaml::parse($dataString);

        return new Resource($data);
    }
}