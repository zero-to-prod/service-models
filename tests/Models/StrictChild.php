<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

#[Describe(['strict' => true])]
class StrictChild
{
    use ServiceModel;

    public const name = 'name';
    public const id = 'id';
    public readonly string $name;
    public int $id;
}