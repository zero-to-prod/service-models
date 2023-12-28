<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\ToChild;
use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCast
{
    use ServiceModel;

    public const child = 'child';
    #[Describe(['from' => ToChild::class])]
    public ChildWithoutTrait $child;
}