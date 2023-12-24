<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

/**
 * @property $value
 */
enum Status: string
{
    case pending = 'pending';
    case completed = 'completed';
}