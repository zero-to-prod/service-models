<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

class CustomCast
{
    public function __construct(public readonly string $name, public readonly string $value)
    {
    }
}
