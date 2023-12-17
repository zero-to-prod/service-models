<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

class TimeClass
{
    public string $value;

    public static function parse($value): self
    {
        $instance = new self();
        $instance->value = $value;

        return $instance;
    }
}