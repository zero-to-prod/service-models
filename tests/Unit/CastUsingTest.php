<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastUsingClass;
use Zerotoprod\AppServiceModel\Tests\Models\SpecialCast;
use Zerotoprod\AppServiceModel\Tests\Models\SpecialCastValues;

test('cast using', function () {
    $CastUsingClass = CastUsingClass::from([
        CastUsingClass::value => 'value',
        CastUsingClass::values => [
            'id' => 'id',
            'name' => 'name'
        ],
    ]);
    expect($CastUsingClass->value)->toBeInstanceOf(SpecialCast::class)
        ->and($CastUsingClass->value->value)->toBe('value')
        ->and($CastUsingClass->values)->toBeInstanceOf(SpecialCastValues::class)
        ->and($CastUsingClass->values->id)->toBe('id')
        ->and($CastUsingClass->values->name)->toBe('name');
});