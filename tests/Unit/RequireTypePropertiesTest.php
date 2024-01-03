<?php

use Zerotoprod\AppServiceModel\Tests\Models\RequireTypedPropertiesClass;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

test('map from', function () {
    RequireTypedPropertiesClass::from([
        RequireTypedPropertiesClass::name => 'name'
    ]);
})->expectException(ValidationException::class);