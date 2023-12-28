<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\DescribeModel;
use Zerotoprod\ServiceModel\ServiceModel;

#[DescribeModel(['strict' => true])]
class ValidationClass
{
    use ServiceModel;

    public const ro_required = 'ro_required';
    public const required = 'required';
    public const ro_qu_string = 'ro_qu_string';
    public const ro_null_string = 'ro_null_string';
    public const qu = 'qu';
    public const qu_null = 'qu_null';
    public const child = 'child';
    public const strict_child = 'strict_child';

    public readonly string $ro_required;
    public string $required;
    public readonly ?string $ro_qu_string;
    public readonly null|string $ro_null_string;
    public ?string $qu;
    public null|string $qu_null;

    public readonly Child $child;
    public readonly StrictChild $strict_child;
}