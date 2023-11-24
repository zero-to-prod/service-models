<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class OptionalValues
{
    use ServiceModel;

    public const int = 'int';
    public const float = 'float';
    public const string = 'string';
    public const bool = 'bool';
    public const array = 'array';
    public const object = 'object';
    public ?int $int = null;
    public ?float $float = null;
    public ?string $string = null;
    public ?bool $bool = null;
    public ?array $array = null;
    public ?object $object = null;
}