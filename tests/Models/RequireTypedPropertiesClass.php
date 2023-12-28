<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\DescribeModel;
use Zerotoprod\ServiceModel\ServiceModel;

#[DescribeModel([
    'require_typed_properties' => true,
])]
class RequireTypedPropertiesClass
{
    use ServiceModel;

    public const name = 'name';

    public $name;
}