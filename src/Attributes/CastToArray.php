<?php

namespace Zerotoprod\ServiceModel\Attributes;
use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CastToArray implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $value): array
    {
        $results = [];

        foreach ($value as $item) {
            $results[] = $this->class::make($item);
        }

        return $results;
    }
}
