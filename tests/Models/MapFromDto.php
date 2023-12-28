<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class MapFromDto
{
    use ServiceModel;

    #[Describe(['map_from' => 'MyValue'])]
    public readonly string $my_value;
    #[Describe(['map_from' => 'value_1.value'])]
    public readonly string $value_2;
}