<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

class CustomCastWithConstructor
{
    public function __construct(public string $name)
    {
    }
}
