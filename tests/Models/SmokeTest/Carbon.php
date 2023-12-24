<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

class Carbon
{

    public function __construct(public readonly string $time)
    {
    }

    public static function parse(string $time): static
    {
        return new static($time);
    }
}