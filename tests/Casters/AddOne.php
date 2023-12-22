<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\ServiceModel\Contracts\CanParse;

class AddOne implements CanParse
{
    public function parse(array $values): int
    {
        return $values[0] + 1;
    }
}