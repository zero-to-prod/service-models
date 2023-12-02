<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class WrongChild
{
    use ServiceModel;
    public const name = 'name';
    public readonly string $name;
}