<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;
use function Zerotoprod\ServiceModel\Attributes\enum_exists;

#[Attribute]
class CustomValueCaster implements CanParse
{
    public function __construct(public readonly int $value, public readonly int $anotherValue)
    {
    }

    public function parse(array $values): int
    {
        return $values[0] + $this->value + $this->anotherValue;
    }
}