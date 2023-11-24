<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelWithoutChildTrait
{
    use ServiceModel;

    public const child = 'child';
    public ChildWithoutTrait $child;
}