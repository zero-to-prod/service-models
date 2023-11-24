<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;

class TopLevel
{
    use ServiceModel;

    public const child = 'child';
    public Child $child;
}