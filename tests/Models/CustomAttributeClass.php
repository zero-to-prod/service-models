<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Casters\CustomAttribute;
use Zerotoprod\ServiceModel\ServiceModel;

class CustomAttributeClass
{
    use ServiceModel;

    public const value = 'value';
    #[CustomAttribute(1)]
    public array $value;
}