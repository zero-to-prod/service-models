<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\ServiceModel\CanCast;

class CustomArrayCast implements CanCast
{
    public function set(array $value): ChildWithoutTrait
    {
        $child = new ChildWithoutTrait;
        $child->name = $value['name'];

        return $child;
    }
}