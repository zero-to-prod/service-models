<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\CastToArray;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCastArray
{
    use ServiceModel;

    public const children = 'children';

    /**
     * @var Child[] $children
     */
    #[CastToArray(Child::class)]
    public array $children;
}