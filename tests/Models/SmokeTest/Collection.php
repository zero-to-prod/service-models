<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

class Collection
{
    public const items = 'items';

    public function __construct(public readonly array $items)
    {
    }

    public function first()
    {
        return $this->items[0];
    }
}