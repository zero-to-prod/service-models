<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use DateTime;
use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class CastToClass
{
    use ServiceModel;

    public const time = 'time';
    public const enums = 'enums';
    public const enum_value = 'enum_value';
    public const times = 'times';
    public const custom_classes = 'custom_classes';
    public const custom_classes_1 = 'custom_classes_1';
    public const custom_class = 'custom_class';
    public const custom_class_1 = 'custom_class_1';
    public readonly DateTime $time;
    #[Describe(['from' => MockStringEnum::class])]
    public readonly array $enums;
    #[Describe(['from' => DateTime::class])]
    public readonly array $times;
    #[Describe(['from' => MockEnum::class])]
    public readonly array $enum_value;
    #[Describe(['from' => CustomCast::class])]
    public readonly array $custom_classes;
    #[Describe(['from' => CustomCastOne::class])]
    public readonly array $custom_classes_1;
    public readonly CustomCast $custom_class;
    public readonly CustomCastOne $custom_class_1;
}