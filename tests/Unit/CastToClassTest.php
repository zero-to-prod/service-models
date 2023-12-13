<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastToClass;
use Zerotoprod\AppServiceModel\Tests\Models\CustomCast;
use Zerotoprod\AppServiceModel\Tests\Models\CustomCastOne;

test('date time', function () {
    expect(CastToClass::make([CastToClass::time => '2021-01-01 00:00:00'])->time)
        ->toBeInstanceOf(DateTime::class);
});

test('date time array', function () {
    expect(CastToClass::make([CastToClass::times => ['2021-01-01 00:00:00']])->times[0])
        ->toBeInstanceOf(DateTime::class);
});

test('cast to classes', function () {
    $CustomCast = CastToClass::make([CastToClass::custom_classes => [
        [
            'name' => 'name',
            'value' => '2021-01-01 00:00:00'
        ]
    ]])->custom_classes[0];

    expect($CustomCast)->toBeInstanceOf(CustomCast::class)
        ->and($CustomCast->name)->toBe('name')
        ->and($CustomCast->value)->toBe('2021-01-01 00:00:00');
});

test('cast to classes one', function () {
    $CustomCast = CastToClass::make([CastToClass::custom_classes_1 => [
        [
            'name' => 'name',
        ]
    ]])->custom_classes_1[0];

    expect($CustomCast)->toBeInstanceOf(CustomCastOne::class)
        ->and($CustomCast->name)->toBe('name');
});

test('cast to class', function () {
    $CustomCast = CastToClass::make([CastToClass::custom_class => [
        'name' => 'name',
        'value' => '2021-01-01 00:00:00'
    ]])->custom_class;

    expect($CustomCast)->toBeInstanceOf(CustomCast::class)
        ->and($CustomCast->name)->toBe('name')
        ->and($CustomCast->value)->toBe('2021-01-01 00:00:00');
});

test('cast to class with one argument', function () {
    $CustomCastOne = CastToClass::make([CastToClass::custom_class_1 => [
        'name' => 'name',
    ]])->custom_class_1;

    expect($CustomCastOne)->toBeInstanceOf(CustomCastOne::class)
        ->and($CustomCastOne->name)->toBe('name');
});