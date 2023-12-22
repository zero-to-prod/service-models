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

    public function parse(array $values): mixed
    {
        return strpos($this->map, '.')
            ? $this->valueByPath($values, $this->map)
            : $values[0];
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
