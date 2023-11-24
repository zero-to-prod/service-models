<?php

use Zerotoprod\AppServiceModel\Tests\Models\NativeTypes;

test('native types', function () {
    $NativeTypes = NativeTypes::make([
        NativeTypes::int => 1,
        NativeTypes::float => 1.1,
        NativeTypes::string => 'string',
        NativeTypes::bool => true,
        NativeTypes::array => [],
        NativeTypes::object => new stdClass(),
    ]);

    expect($NativeTypes->int)->toBe(1)
        ->and($NativeTypes->float)->toBe(1.1)
        ->and($NativeTypes->string)->toBe('string')
        ->and($NativeTypes->bool)->toBe(true)
        ->and($NativeTypes->array)->toBe([])
        ->and($NativeTypes->object)->toBeInstanceOf(stdClass::class);
});