<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\CastToArray;
use Zerotoprod\ServiceModel\Attributes\MapOutputNames;
use Zerotoprod\ServiceModel\Attributes\ToSnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[MapOutputNames(ToSnakeCase::class)]
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
    #[CastToArray(NestedOutputNamesClass::class)]
    public readonly array $ArrayNestedOutputNamesClass;
    public readonly MockEnumCast $Enum;
}