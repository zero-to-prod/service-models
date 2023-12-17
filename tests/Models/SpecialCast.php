<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

class SpecialCast
{
    public string $value;

    public static function set($value): self
    {
        $instance = new self();
        $instance->value = $value;

        return $instance;
    }
}