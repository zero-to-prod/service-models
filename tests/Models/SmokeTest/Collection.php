<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

class Collection
{
    public const items = 'items';
    public readonly array $items;

    public function __construct(...$items)
    {
        $this->items = $items;
    }

    public function first(): View
    {
        return View::from($this->items[0]);
    }
}