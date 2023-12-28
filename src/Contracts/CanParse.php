<?php

namespace Zerotoprod\ServiceModel\Contracts;

interface CanParse
{
    public function parse(mixed $value); // @pest-ignore-type
}
