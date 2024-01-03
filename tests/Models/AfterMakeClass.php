<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class AfterMakeClass
{
    use ServiceModel;

    public string $value_4;

    public function afterMake($items): void
    {
        $this->value_4 = $items['MyValue'];
    }
}