<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class MapFromNestedDto
{
    use ServiceModel;

    #[Describe(['map_from' => 'value.value_nested'])]
    public readonly string $value;

    #[Describe(['map_from' => 'my_value'])]
    public readonly string $my_value;

    #[Describe(['map_from' => 'two.two_nested'])]
    public readonly string $value2;

    #[Describe(['map_from' => 'three.three_nested.three_nested_nested'])]
    public readonly string $value3;

    public readonly string $test;
}