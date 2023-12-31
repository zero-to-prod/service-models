<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedMethodInspection
 */

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ArrayOf implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): array
    {
        $results = [];

        foreach ($values as $item) {
            if (method_exists($this->class, 'make')) {
                $results[] = $this->class::make($item);

                continue;
            }

            if (method_exists($this->class, 'tryFrom')) {
                $results[] = isset($item->value) ? $item : $this->class::tryFrom($item);

                continue;
            }

            $results[] = is_array($item)
                ? new $this->class(...$item)
                : new $this->class($item);
        }

        return $results;
    }
}
