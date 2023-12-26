<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class Child
{
    use ServiceModel;

    public const name = 'name';
    public const id = 'id';
    public readonly string $name;
    public int $id;
}