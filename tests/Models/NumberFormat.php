<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class NumberFormat
{
    use ServiceModel;

    public const value = 'value';
    #[\Zerotoprod\ServiceModel\Attributes\NumberFormat(2, ',', '.')]
    public string $value;
}