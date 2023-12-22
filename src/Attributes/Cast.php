<?php /** @noinspection PhpUndefinedClassInspection */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class Cast implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values)
    {
        return (new $this->class)->parse($values);
    }
}