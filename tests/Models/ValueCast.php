<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\AddOne;
use Zerotoprod\ServiceModel\Attributes\Cast;
use Zerotoprod\ServiceModel\ServiceModel;

class ValueCast
{
    use ServiceModel;

    public const value = 'value';
    #[Cast(AddOne::class)]
    public int $value;
}