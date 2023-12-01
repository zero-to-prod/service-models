<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\CastToArray;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCastArrayEnums
{
    use ServiceModel;

    public const children = 'children';

    /**
     * @var MockEnumCast[] $children
     */
    #[CastToArray(MockEnumCast::class)]
    public array $children;
}