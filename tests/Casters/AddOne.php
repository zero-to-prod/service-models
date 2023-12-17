<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\ServiceModel\Contracts\CanParse;

class AddOne implements CanParse
{
    public function parse(array $value): int
    {
        return $value[0] + 1;
    }
}