<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\ServiceModel;
use Zerotoprod\ServiceModel\Strict;

class StrictClass
{
    use ServiceModel;
    use Strict;

    public const ro_required = 'ro_required';
    public const enum_required = 'enum_required';
    public const required = 'required';
    public const ro_qu_string = 'ro_qu_string';
    public const ro_null_string = 'ro_null_string';
    public const qu = 'qu';
    public const qu_null = 'qu_null';

    public readonly string $ro_required;
    public readonly MockEnumCast $enum_required;
    public string $required;
    public readonly ?string $ro_qu_string;
    public readonly null|string $ro_null_string;
    public ?string $qu;
    public null|string $qu_null;
}