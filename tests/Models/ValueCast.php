<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\AddOne;
use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class ValueCast
{
    use ServiceModel;

    public const value = 'value';
    #[Describe(['from' => AddOne::class])]
    public int $value;
}