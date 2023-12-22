<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapFromDto;
use Zerotoprod\AppServiceModel\Tests\Models\MapFromNestedDto;

test('map from', function () {
    $MapFromDto = MapFromDto::make([
        'value_1' => 'test1',
        'value_2' => 'test2'
    ]);

    expect($MapFromDto->value_2)->toBe('test1');
});
test('map from missed', function () {
    MapFromDto::make([
        'value_3' => 'test'
    ])->value_2;
})->expectException(RuntimeException::class);

test('map from nested', function () {
    $MapFromDto = MapFromNestedDto::make([
        'value_1' => [
            'value' => 'test1'
        ],
        'value_2' => [
            'value' => 'test2'
        ]
    ]);

    expect($MapFromDto->value_2)->toBe('test1');
});

test('map from nested missed', function () {
    MapFromNestedDto::make([
        'value_1' => [
            'value2' => 'test'
        ]
    ])->value_2;
})->expectException(RuntimeException::class);