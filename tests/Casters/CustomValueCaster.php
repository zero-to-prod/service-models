<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CustomValueCaster implements CanParse
{
    public function __construct(public readonly int $value_1, public readonly int $value_2)
    {

    }

    public function parse(mixed $value): int
    {
        return $value + $this->value_1 + $this->value_2;
    }
}
