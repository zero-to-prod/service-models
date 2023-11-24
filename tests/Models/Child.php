<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class Child
{
    use ServiceModel;
    public const name = 'name';
    public readonly string $name;
}