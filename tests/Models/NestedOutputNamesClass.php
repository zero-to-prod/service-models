<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\Attributes\SnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[Describe(['output_as' => SnakeCase::class])]
class NestedOutputNamesClass
{
    use ServiceModel;

    public const Name = 'Name';
    public readonly string $Name;
}