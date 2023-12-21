<?php
// @codeCoverageIgnoreStart
namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class Cast
{
    public function __construct(public readonly string $class)
    {
    }
}
// @codeCoverageIgnoreEnd