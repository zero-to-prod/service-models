<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapFromDto;
use Zerotoprod\AppServiceModel\Tests\Models\MapFromNestedDto;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\Carbon;

test('map from', function () {
    $MapFromDto = MapFromDto::make([
        'MyValue' => 'value',
        'value_1' => [
            'value' => 'value2'
        ],
    ]);

    expect($MapFromDto->my_value)->toBe('value')
        ->and($MapFromDto->value_2)->toBe('value2');
});
test('map from missed', function () {
    MapFromDto::make([
        'value_3' => 'test'
    ])->my_value;
})->expectException(TypeError::class);

test('map from nested', function () {
    $MapFromDto = MapFromNestedDto::make([
        'bogus' => [
            'bogus nested' => 'bogus value'
        ],
        'value' => [
            'value_nested' => 'value_nested_value'
        ],
        'two' => [
            'two_nested' => 'two_nested_value'
        ],
        'three' => [
            'three_nested' => [
                'three_nested_nested' => 'three_nested_nested_value'
            ]
        ],
        'test' => 'test'
    ]);

    expect($MapFromDto->value)->toBe('value_nested_value')
        ->and($MapFromDto->value2)->toBe('two_nested_value')
        ->and($MapFromDto->value3)->toBe('three_nested_nested_value')
        ->and($MapFromDto->test)->toBe('test');
});

test('map casted', function () {
    $MapFromDto = MapFromNestedDto::make([
        'map_from_casted' => ['2021-01-01 00:00:00']
    ]);

    expect($MapFromDto->map_from_casted)->toBeInstanceOf(Carbon::class);
});

//test('map from nested 0', function () {
//    $MapFromDto = MapFromNestedDto::make([
//        'nested_value' => ['test22']
//    ]);
//
//    expect($MapFromDto->map_from_nested)->toBe('test22');
//});