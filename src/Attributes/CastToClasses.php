<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

/**
 * @deprecated use ArrayOf instead
 */
#[Attribute]
class CastToClasses implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): array
    {
        return (new ArrayOf($this->class))->parse($values);
    }
}
