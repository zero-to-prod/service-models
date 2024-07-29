<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\AppServiceModel\Tests\Casters;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CustomAttribute
{
    public function __construct(public readonly int $value)
    {
    }
}
