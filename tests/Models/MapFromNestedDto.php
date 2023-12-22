<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\ServiceModel;

class MapFromNestedDto
{
    use ServiceModel;

    #[MapFrom('value_1.value')]
    public readonly string $value_2;
}