<?php /** @noinspection PhpUndefinedClassInspection */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use UnitEnum;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ToArray implements CanParse
{
    public function parse(mixed $value): array
    {
        $result = [];
        $items = $value;
        foreach ($items as $key => $item) {
            if ($item instanceof UnitEnum) {
                $item = $item->value;
            } elseif (is_object($item)) {
                $item = get_object_vars($item);
            }
            if (is_array($item)) {
                $result[$key] = $this->parse($item);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}