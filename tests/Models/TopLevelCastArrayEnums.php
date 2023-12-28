<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCastArrayEnums
{
    use ServiceModel;

    public const children = 'children';

    /**
     * @var MockEnumCast[] $children
     */
    #[Describe(['from' => MockEnumCast::class])]
    public array $children;
}