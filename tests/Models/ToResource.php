<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class ToResource
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