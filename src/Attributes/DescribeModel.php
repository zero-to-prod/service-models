<?php

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;

#[Attribute]
class DescribeModel
{
    public bool $strict = false;
    public bool $require_typed_properties = false;
    public ?string $output_as = null;

    /**
     * @param string|null|array{
     *     strict?: bool,
     *     require_typed_properties?: bool,
     *     output_as?: string,
     * } $attributes
     */
    public function __construct(string|array|null $attributes = null)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}