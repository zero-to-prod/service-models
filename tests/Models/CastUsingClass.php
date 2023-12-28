<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class CastUsingClass
{
    use ServiceModel;

    public const value = 'value';
    public const values = 'values';
    public const time = 'time';

    #[Describe(['via' => 'set'])]
    public SpecialCast $value;
    #[Describe(['via' => 'set'])]
    public SpecialCastValues $values;
    public TimeClass $time;
}