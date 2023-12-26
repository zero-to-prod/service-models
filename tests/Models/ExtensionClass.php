<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\AppServiceModel\Tests\Traits\TestServiceModel;

class ExtensionClass
{
    use TestServiceModel;

    public const child = 'child';
    public ExtensionChildClass $child;
}