<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\CastUsing;
use Zerotoprod\ServiceModel\ServiceModel;

class CastUsingClass
{
    use ServiceModel;

    public const value = 'value';
    public const values = 'values';
    public const time = 'time';

    #[CastUsing('set')]
    public SpecialCast $value;
    #[CastUsing('set')]
    public SpecialCastValues $values;
    public TimeClass $time;
}