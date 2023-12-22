<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\ServiceModel;

class MapFromNestedDto
{
    use ServiceModel;

    #[MapFrom('value.value_nested')]
    public readonly string $value;

    #[MapFrom('two.two_nested')]
    public readonly string $value2;

    #[MapFrom('three.three_nested.three_nested_nested')]
    public readonly string $value3;
}