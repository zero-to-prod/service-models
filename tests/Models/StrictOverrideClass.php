<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

#[Describe(['strict' => true])]
class StrictOverrideClass
{
    use ServiceModel;

    public const overridden = 'overridden';
    public const required = 'required';

    #[Describe(['strict' => false])]
    public readonly string $overridden;
    public readonly string $required;
}