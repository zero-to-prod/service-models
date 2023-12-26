<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;
use Zerotoprod\ServiceModel\Strict;

class StrictChild
{
    use ServiceModel;
    use Strict;

    public const name = 'name';
    public const id = 'id';
    public readonly string $name;
    public int $id;
}