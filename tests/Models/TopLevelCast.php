<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\ToChild;
use Zerotoprod\ServiceModel\Attributes\Cast;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCast
{
    use ServiceModel;

    public const child = 'child';
    #[Cast(ToChild::class)]
    public ChildWithoutTrait $child;
}