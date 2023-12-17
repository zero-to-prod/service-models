<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastMethodClass;
use Zerotoprod\AppServiceModel\Tests\Models\SpecialCast;

test('top level value cast', function () {
    $CastMethodClass = CastMethodClass::make([
        CastMethodClass::value => 'value'
    ]);
    expect($CastMethodClass->value)->toBeInstanceOf(SpecialCast::class)
        ->and($CastMethodClass->value->value)->toBe('value');
});