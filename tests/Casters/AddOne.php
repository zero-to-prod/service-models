<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\ServiceModel\Contracts\CanParse;

class AddOne implements CanParse
{
    public function parse(mixed $value): int
    {
        return $value + 1;
    }
}