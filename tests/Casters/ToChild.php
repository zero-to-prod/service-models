<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\ServiceModel\Contracts\CanParse;

class ToChild implements CanParse
{
    public function parse(array $values): ChildWithoutTrait
    {
        $child = new ChildWithoutTrait;
        $child->name = $values['name'];

        return $child;
    }
}