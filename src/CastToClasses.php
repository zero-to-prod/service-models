<?php

namespace Zerotoprod\ServiceModel;

use Attribute;

#[Attribute]
class CastToClasses implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set(array $value): array
    {
        $results = [];

        foreach ($value as $item) {
            if (is_array($item)) {
                $results[] = new $this->class(...$item);
                continue;
            }
            $results[] = new $this->class($item);
        }

        return $results;
    }
}
