<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class FactoryModelChild
{
    use ServiceModel;

    public const name = 'name';

    public readonly string $name;
}