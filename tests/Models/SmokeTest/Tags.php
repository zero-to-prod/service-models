<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

/**
 * @property $value
 */
enum Tags: string
{
    case pending = 'pending';
    case completed = 'completed';
}