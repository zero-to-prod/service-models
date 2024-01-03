<?php /** @noinspection PhpUndefinedConstantInspection */

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ToJson implements CanParse
{
    public function parse(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }
}