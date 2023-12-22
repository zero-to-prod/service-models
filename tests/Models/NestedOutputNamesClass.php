<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\MapOutputNames;
use Zerotoprod\ServiceModel\Attributes\ToSnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[MapOutputNames(ToSnakeCase::class)]
class NestedOutputNamesClass
{
    use ServiceModel;

    public const Name = 'Name';
    public readonly string $Name;
}