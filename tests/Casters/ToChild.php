<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\ServiceModel\Contracts\CanParse;

class ToChild implements CanParse
{
    public function parse(array $value): ChildWithoutTrait
    {
        $child = new ChildWithoutTrait;
        $child->name = $value['name'];

        return $child;
    }
}