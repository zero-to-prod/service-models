<?php

use Zerotoprod\AppServiceModel\Tests\Models\MockEnum;
use Zerotoprod\AppServiceModel\Tests\Models\MockEnumString;
use Zerotoprod\AppServiceModel\Tests\Models\UsesEnum;

test('casts to string enum', function () {
    $UsesEnum = UsesEnum::from([
        UsesEnum::name => MockEnumString::test->value
    ]);
    expect($UsesEnum->name)->toBeInstanceOf(MockEnumString::class)
        ->and($UsesEnum->name)->toBe(MockEnumString::test);
});

test('handles enum', function () {
    $UsesEnum = UsesEnum::from([
        UsesEnum::name => MockEnumString::test
    ]);
    expect($UsesEnum->name)->toBeInstanceOf(MockEnumString::class)
        ->and($UsesEnum->name)->toBe(MockEnumString::test);
});


test('type error when Enum is passed', function () {
    UsesEnum::from([UsesEnum::name => MockEnum::test]);
})->expectException(TypeError::class);

test('casts to enum', function () {
    UsesEnum::from([UsesEnum::name => MockEnum::test->value])->name;
})->expectException(Throwable::class);