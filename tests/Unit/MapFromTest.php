<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapFromDto;
use Zerotoprod\AppServiceModel\Tests\Models\MapFromNestedDto;

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
        ]
    ]);

    expect($MapFromDto->value)->toBe('value_nested_value')
        ->and($MapFromDto->value2)->toBe('two_nested_value')
        ->and($MapFromDto->value3)->toBe('three_nested_nested_value');
});

//test('map from nested missed', function () {
//    MapFromNestedDto::make([
//        'value_1' => [
//            'value2' => 'test'
//        ]
//    ])->value;
//})->expectException(Error::class);