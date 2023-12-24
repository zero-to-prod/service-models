<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

use Zerotoprod\ServiceModel\ServiceModel;

class OrderDetails
{
    use ServiceModel;

    public const id = 'id';
    public const name = 'name';

    public readonly int $id;
    public readonly string $name;
}