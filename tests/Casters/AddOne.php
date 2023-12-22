<?php

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Zerotoprod\ServiceModel\Contracts\CanParse;

class AddOne implements CanParse
{
    public function parse(array $property_values): int
    {
        return $property_values[0] + 1;
    }
}