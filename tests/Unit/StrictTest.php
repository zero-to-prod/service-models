<?php

use Zerotoprod\AppServiceModel\Tests\Models\MockEnumCast;
use Zerotoprod\AppServiceModel\Tests\Models\StrictClass;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

test('validates', function () {
    StrictClass::make();
})->throws(ValidationException::class);
test('validates multiple', function () {
    StrictClass::make([
        StrictClass::required => 'value',
    ]);
})->throws(ValidationException::class);
test('validates enum', function () {
    StrictClass::make([
        StrictClass::required => 'value',
        StrictClass::ro_required => 'value',
    ]);
})->throws(ValidationException::class);

test('passes', function () {
    StrictClass::make([
        StrictClass::required => 'value',
        StrictClass::ro_required => 'value',
        StrictClass::enum_required => MockEnumCast::first,
    ]);
})->throwsNoExceptions();

test('passes enum value', function () {
    StrictClass::make([
        StrictClass::required => 'value',
        StrictClass::ro_required => 'value',
        StrictClass::enum_required => MockEnumCast::first->value,
    ]);
})->throwsNoExceptions();