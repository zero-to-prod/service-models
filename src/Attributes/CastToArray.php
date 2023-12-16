<?php

namespace Zerotoprod\ServiceModel\Attributes;
use Attribute;
use Zerotoprod\ServiceModel\CanCast;

#[Attribute]
class CastToArray implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set(array $value): array
    {
        $results = [];

        foreach ($value as $item) {
            $results[] = $this->class::make($item);
        }

        return $results;
    }
}
