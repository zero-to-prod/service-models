<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\CustomCaster;
use Zerotoprod\AppServiceModel\Tests\Casters\CustomValueCaster;
use Zerotoprod\ServiceModel\ServiceModel;

class CustomCastClass
{
    use ServiceModel;

    public const add_one = 'add_one';
    public const add_two = 'add_two';

    #[CustomCaster(1)]
    public readonly int $add_one;
    #[CustomValueCaster(1, 2)]
    public readonly int $add_two;
}