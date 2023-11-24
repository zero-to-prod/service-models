<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\ToChild;
use Zerotoprod\ServiceModel\ServiceModel;
use Zerotoprod\ServiceModel\Cast;

class TopLevelCast
{
    use ServiceModel;

    public const child = 'child';
    #[Cast(ToChild::class)]
    public ChildWithoutTrait $child;
}