<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

class TimeClass
{
    public string $value;

    public static function set($value): self
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }
}