<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class UsesEnum
{
    use ServiceModel;
    public const name = 'name';
    public readonly MockEnumString $name;
}