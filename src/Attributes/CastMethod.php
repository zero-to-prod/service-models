<?php

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class CastMethod
{
    public function __construct(public readonly string $method_name)
    {
    }
}
