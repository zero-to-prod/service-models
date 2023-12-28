<?php

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class Describe
{
    public ?string $from = null;
    public ?string $via = null;
    public ?string $map_from = null;

    /**
     * @param string|null|array{
     *      from?: string,
     *      via?: string,
     *      map_from?: string
     * } $attributes
     */
    public function __construct(string|array|null $attributes = null)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}