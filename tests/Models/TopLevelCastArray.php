<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class TopLevelCastArray
{
    use ServiceModel;

    public const children = 'children';

    /**
     * @var Child[] $children
     */
    #[Describe(['from' => Child::class])]
    public readonly array $children;
}