<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\ServiceModel\Contracts\CanCast;

class AddOne implements CanCast
{
    public function set(array $value): int
    {
        return $value[0] + 1;
    }
}