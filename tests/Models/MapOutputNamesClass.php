<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\Attributes\DescribeModel;
use Zerotoprod\ServiceModel\Attributes\SnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[DescribeModel(['output_as' => SnakeCase::class])]
class MapOutputNamesClass
{
    use ServiceModel;

    public const Name = 'Name';
    public const LastName = 'LastName';
    public const NestedOutputNamesClass = 'NestedOutputNamesClass';
    public const ArrayNestedOutputNamesClass = 'ArrayNestedOutputNamesClass';
    public const Enum = 'Enum';
    public readonly string $Name;
    public readonly string $LastName;
    public readonly NestedOutputNamesClass $NestedOutputNamesClass;
    #[Describe(['from' => NestedOutputNamesClass::class])]
    public readonly array $ArrayNestedOutputNamesClass;
    public readonly MockEnumCast $Enum;
}