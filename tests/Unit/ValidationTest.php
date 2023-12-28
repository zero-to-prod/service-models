<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\ValidationClass;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

test('validates', function () {
    ValidationClass::from()->validate();
})->throws(ValidationException::class);
test('validates multiple', function () {
    ValidationClass::from([
        ValidationClass::required => 'value',
    ])->validate();
})->throws(ValidationException::class);
test('validates child', function () {
    ValidationClass::from([
        ValidationClass::required => 'value',
        ValidationClass::ro_required => 'value',
        ValidationClass::strict_child => [
            'a' => 1,
        ],
    ])->validate();
})->throws(ValidationException::class);
test('does not validate child recursive', function () {
    ValidationClass::from([
        ValidationClass::required => 'value',
        ValidationClass::ro_required => 'value',
        ValidationClass::child => [
            Child::id => 1,
        ],
        ValidationClass::strict_child => [
            Child::id => 1,
        ],
    ])->validate();
})->throwsNoExceptions();
test('validate child recursive', function () {
    ValidationClass::from([
        ValidationClass::required => 'value',
        ValidationClass::ro_required => 'value',
        ValidationClass::child => [
            Child::id => 1,
        ],
    ])->validate();
})->throws(ValidationException::class);
test('passes', function () {
    ValidationClass::from([
        ValidationClass::required => 'value',
        ValidationClass::ro_required => 'value',
        ValidationClass::child => [
            Child::id => 1,
            Child::name => 'name',
        ],
        ValidationClass::strict_child => [
            Child::id => 1,
            Child::name => 'name',
        ],
    ])->validate();
})->throwsNoExceptions();