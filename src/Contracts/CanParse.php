<?php

namespace Zerotoprod\ServiceModel\Contracts;

interface CanParse
{
    public function parse(array $values); // @pest-ignore-type
}
