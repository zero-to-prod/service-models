<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CastToClasses implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): array
    {
        $results = [];

        foreach ($values as $value) {
            if (is_array($value)) {
                $results[] = new $this->class(...$value);
                continue;
            }

            if ((is_int($value) || is_string($value))
                && enum_exists($this->class)
                && method_exists($this->class, 'tryFrom')
            ) {
                $results[] = $this->class::tryFrom($value);
                continue;
            }

            $results[] = new $this->class($value);
        }

        return $results;
    }
}
