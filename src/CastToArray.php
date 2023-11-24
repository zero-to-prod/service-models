<?php

namespace Zerotoprod\ServiceModel;
use Attribute;

#[Attribute]
class CastToArray implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set($value): array
    {
        $results = [];

        foreach ($value as $item) {
            $results[] = $this->class::make($item);
        }

        return $results;
    }
}
