<?php

namespace Zerotoprod\ServiceModel\Attributes;

use Attribute;
use Closure;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class NumberFormat implements CanParse
{
    public function __construct(
        readonly public int    $decimals = 0,
        readonly public string $dec_point = '.',
        readonly public string $thousands_sep = ','
    )
    {
    }

    public function parse(array $values): string
    {
        return number_format($values[0], $this->decimals, $this->dec_point, $this->thousands_sep);
    }
}
