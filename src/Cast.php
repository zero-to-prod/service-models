<?php

namespace Zerotoprod\ServiceModel;

use Attribute;

#[Attribute]
class Cast
{
    public function __construct(public readonly string $class)
    {
    }
}
