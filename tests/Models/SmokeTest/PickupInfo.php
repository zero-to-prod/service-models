<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

class PickupInfo
{
    public const location = 'location';
    public const time = 'time';

    public function __construct(public readonly string $location, public readonly string $time,)
    {
    }
}