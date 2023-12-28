<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\DescribeModel;
use Zerotoprod\ServiceModel\Attributes\SnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[DescribeModel(['output_as' => SnakeCase::class])]
class NestedOutputNamesClass
{
    use ServiceModel;

    public const Name = 'Name';
    public readonly string $Name;
}