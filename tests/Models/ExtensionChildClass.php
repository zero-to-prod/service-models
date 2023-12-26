<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Traits\TestServiceModel;

class ExtensionChildClass
{
    use TestServiceModel;

    public const name = 'name';
    public const id = 'id';
    public readonly string $name;
    public int $id;
}