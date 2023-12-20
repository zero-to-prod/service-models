<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\HasFactory;

class PlainFactoryModel
{
    use HasFactory;

    public static string $factory = PlainFactoryModelFactory::class;

    public const name = 'name';
    public const Child = 'Child';

    public readonly string $name;
    public readonly FactoryModelChild $Child;
}