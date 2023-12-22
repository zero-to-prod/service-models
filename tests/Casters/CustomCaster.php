<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CustomCaster implements CanParse
{
    public function __construct(public readonly int $attribute_constructor_value)
    {
    }

    public function parse(array $values): int
    {
        return $values[0] + $this->attribute_constructor_value;
    }
}
