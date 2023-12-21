<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\HasFactory;

class PlainFactoryModel
{
    use HasFactory;

    public static string $factory = PlainFactoryModelFactory::class;

    public function __construct(public $attributes)
    {

    }
}