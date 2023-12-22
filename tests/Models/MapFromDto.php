<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\ServiceModel;

class MapFromDto
{
    use ServiceModel;

    #[MapFrom('MyValue')]
    public readonly string $my_value;
    #[MapFrom('value_1.value')]
    public readonly string $value_2;
    public string $value_4;

    public function afterMake($items): void
    {
        $this->value_4 = $items['MyValue'];
    }
}