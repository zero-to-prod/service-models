<?php
// @codeCoverageIgnoreStart
namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class CastUsing
{
    public function __construct(public readonly string $method_name)
    {
    }
}
// @codeCoverageIgnoreEnd