<?php
// @codeCoverageIgnoreStart
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class MapOutputNames
{
    public function __construct(public readonly string $map)
    {
    }
}
// @codeCoverageIgnoreEnd