<?php

use Zerotoprod\AppServiceModel\Tests\Models\NativeTypes;

test('passing null', function () {
    expect(NativeTypes::from())->toBeInstanceOf(NativeTypes::class);
});

test('passing empty array', function () {
    expect(NativeTypes::from([]))->toBeInstanceOf(NativeTypes::class);
});

test('passing object', function () {
    expect(NativeTypes::from(new stdClass))->toBeInstanceOf(NativeTypes::class);
});

test('passing string', function () {
    expect(NativeTypes::from(''))->toBeInstanceOf(NativeTypes::class);
});