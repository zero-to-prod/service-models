<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use DateTime;
use Zerotoprod\ServiceModel\ServiceModel;

class DateTimeModel
{
    use ServiceModel;

    public const time = 'time';
    public readonly DateTime $time;
}