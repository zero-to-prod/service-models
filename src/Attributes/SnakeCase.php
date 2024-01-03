<?php /** @noinspection PhpUndefinedClassInspection */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use UnitEnum;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class SnakeCase implements CanParse
{
    public function parse(mixed $value): array
    {
        $result = [];
        $items = $value;
        foreach ($items as $key => $item) {
            $snakeKey = $this->snake($key);
            if ($item instanceof UnitEnum) {
                $item = $item->value;
            } elseif (is_object($item)) {
                $item = get_object_vars($item);
            }
            if (is_array($item)) {
                $result[$snakeKey] = $this->parse($item);
            } else {
                $result[$snakeKey] = $item;
            }
        }
        return $result;
    }

    public function snake(string $value, string $delimiter = '_'): mixed
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return $value;
    }
}