<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\HasFactory;
use Zerotoprod\ServiceModel\ServiceModel;

class FactoryModel
{
    use HasFactory;
    use ServiceModel;

    public static string $factory = FactoryModelFactory::class;

    public const name = 'name';
    public const Child = 'Child';

    public readonly string $name;
    public readonly FactoryModelChild $Child;
}