<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

class SpecialCastValues
{
    public string $id;
    public string $name;

    public static function set(string $id, string $name): self
    {
        $instance = new self();
        $instance->id = $id;
        $instance->name = $name;

        return $instance;
    }
}