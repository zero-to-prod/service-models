<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class NativeTypes
{
    use ServiceModel;

    public const int = 'int';
    public const float = 'float';
    public const string = 'string';
    public const bool = 'bool';
    public const array = 'array';
    public const object = 'object';
    public readonly int $int;
    public readonly float $float;
    public readonly string $string;
    public readonly bool $bool;
    public readonly array $array;
    public readonly object $object;
}