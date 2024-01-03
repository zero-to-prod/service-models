<?php

use Zerotoprod\AppServiceModel\Tests\Models\StrictOverrideClass;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

test('overrides', function () {
    $StrictOverrideClass = StrictOverrideClass::from([
        StrictOverrideClass::required => 'required'
    ]);
    expect($StrictOverrideClass->required)->toBeString()
        ->toBe('required');
});

test('throws error', function () {
    StrictOverrideClass::from([
        StrictOverrideClass::overridden => 'overridden'
    ]);
})->expectException(ValidationException::class);
