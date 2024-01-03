<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

#[Describe(['require_typed_properties' => true])]
class RequireTypedPropertiesClass
{
    use ServiceModel;

    public const name = 'name';

    public $name;
}