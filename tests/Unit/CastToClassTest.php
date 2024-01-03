<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastToClass;
use Zerotoprod\AppServiceModel\Tests\Models\CustomCast;
use Zerotoprod\AppServiceModel\Tests\Models\CustomCastOne;
use Zerotoprod\AppServiceModel\Tests\Models\MockStringEnum;

test('cast to class', function () {
    expect(CastToClass::from([CastToClass::time => '2021-01-01 00:00:00'])->time)
        ->toBeInstanceOf(DateTime::class);
});

test('it can cast to array of DateTime instances', function () {
    expect(CastToClass::from([CastToClass::times => ['2021-01-01 00:00:00']])->times[0])
        ->toBeInstanceOf(DateTime::class);
});

test('it can cast to multiple CustomCast instances', function () {
    $CustomCast = CastToClass::from([CastToClass::custom_classes => [
        [
            'name' => 'name',
            'value' => '2021-01-01 00:00:00'
        ]
    ]])->custom_classes[0];

    expect($CustomCast)->toBeInstanceOf(CustomCast::class)
        ->and($CustomCast->name)->toBe('name')
        ->and($CustomCast->value)->toBe('2021-01-01 00:00:00');
});

test('it can cast to one CustomCastOne instance', function () {
    $CustomCast = CastToClass::from([CastToClass::custom_classes_1 => [
        [
            'name' => 'name',
        ]
    ]])->custom_classes_1[0];

    expect($CustomCast)->toBeInstanceOf(CustomCastOne::class)
        ->and($CustomCast->name)->toBe('name');
});

test('it can cast to a single CustomCast instance', function () {
    $CustomCast = CastToClass::from([CastToClass::custom_class => [
        'name' => 'name',
        'value' => '2021-01-01 00:00:00'
    ]])->custom_class;

    expect($CustomCast)->toBeInstanceOf(CustomCast::class)
        ->and($CustomCast->name)->toBe('name')
        ->and($CustomCast->value)->toBe('2021-01-01 00:00:00');
});

test('it can cast to CustomCastOne instance with one argument', function () {
    $CustomCastOne = CastToClass::from([CastToClass::custom_class_1 => [
        'name' => 'name',
    ]])->custom_class_1;

    expect($CustomCastOne)->toBeInstanceOf(CustomCastOne::class)
        ->and($CustomCastOne->name)->toBe('name');
});

test('it can cast to an array of MockStringEnum instances', function () {
    $enums = CastToClass::from([CastToClass::enums => [
        'test',
    ]])->enums;

    expect($enums[0])->toBeInstanceOf(MockStringEnum::class)
        ->and($enums[0]->value)->toBe('test');
});

test('it throws error when casting to array of single enum value', function () {
    CastToClass::from([CastToClass::enum_value => [
        'test',
    ]])->enums;
})->expectException(Error::class);