<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class MapFrom implements CanParse
{
    public function __construct(public readonly string $map)
    {
    }

    public function parse(mixed $value): mixed
    {
        return strpos($this->map, '.')
            ? $this->valueByPath($value, $this->map)
            : $value[0];
    }

    public function valueByPath(array $array, string $map): array|string|null
    {
        $maps = explode('.', $map);
        array_shift($maps);

        return array_reduce(explode('.', implode('.', $maps)), function (array $carry, string $key) {
            return $carry[$key] ?? [];
        }, $array);
    }
}
