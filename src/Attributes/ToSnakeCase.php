<?php /** @noinspection PhpUndefinedClassInspection */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use UnitEnum;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ToSnakeCase implements CanParse
{
    public function parse(array $values): array
    {
        $result = [];
        foreach ($values as $key => $value) {
            $snakeKey = $this->snake($key);
            if ($value instanceof UnitEnum) {
                $value = $value->value;
            } elseif (is_object($value)) {
                $value = get_object_vars($value);
            }
            if (is_array($value)) {
                $result[$snakeKey] = $this->parse($value);
            } else {
                $result[$snakeKey] = $value;
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