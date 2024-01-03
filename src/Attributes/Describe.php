<?php

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class Describe
{
    public ?string $from = null;
    public bool $strict = false;
    public ?string $via = null;
    public ?string $map_from = null;
    public bool $require_typed_properties = false;
    public ?string $output_as = null;

    /**
     * @param string|null|array{
     *      from?: string,
     *      strict?: bool,
     *      via?: string,
     *      map_from?: string,
     *      require_typed_properties?: bool,
     *      output_as?: string,
     * } $attributes
     */
    public function __construct(string|array|null $attributes = null)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}