<?php /** @noinspection PhpUndefinedClassInspection */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use UnitEnum;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ToArray implements CanParse
{
    public function parse(array $values): array
    {
        $result = [];
        foreach ($values as $key => $value) {
            if ($value instanceof UnitEnum) {
                $value = $value->value;
            } elseif (is_object($value)) {
                $value = get_object_vars($value);
            }
            if (is_array($value)) {
                $result[$key] = $this->parse($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}