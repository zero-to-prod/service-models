<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class WithoutType
{
    use ServiceModel;
    public const name = 'name';
    public $name;
}