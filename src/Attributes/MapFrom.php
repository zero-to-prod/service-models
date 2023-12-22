<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use RuntimeException;

#[Attribute]
class MapFrom
{
    public function __construct(public readonly string $map)
    {
    }

    public function parse(array $values, string $key): mixed
    {
        if (strpos($this->map, '.')) {
            return $this->valueByPath($values, explode('.', $this->map)[1])
                ?? throw new RuntimeException("MapFrom('$key') not found.");
        }

        if ($key === $this->map) {
            return $values[0];
        }

        throw new RuntimeException("MapFrom('$key') not found.");
    }

    public function valueByPath(array $array, string $path): array|string|null
    {
        return array_reduce(explode('.', $path), function (array $carry, string $key) {
            return $carry[$key] ?? null;
        }, $array);
    }
}
