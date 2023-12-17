<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\CastMethod;
use Zerotoprod\ServiceModel\ServiceModel;

class CastMethodClass
{
    use ServiceModel;

    public const value = 'value';
    public const time = 'time';

    #[CastMethod('set')]
    public SpecialCast $value;
    public TimeClass $time;
}