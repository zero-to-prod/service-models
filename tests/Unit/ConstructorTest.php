<?php

use Zerotoprod\AppServiceModel\Tests\Models\NativeTypes;

test('passing null', function () {
    expect(NativeTypes::make())->toBeInstanceOf(NativeTypes::class);
});

test('passing empty array', function () {
    expect(NativeTypes::make([]))->toBeInstanceOf(NativeTypes::class);
});