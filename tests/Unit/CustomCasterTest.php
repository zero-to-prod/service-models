<?php

use Zerotoprod\AppServiceModel\Tests\Models\CustomCastClass;

test('invokes custom caster', function () {
    $ValueCast = CustomCastClass::from([
        CustomCastClass::add_one => 1
    ]);
    expect($ValueCast->add_one)->toBeInt()
        ->and($ValueCast->add_one)->toBe(2);
});

test('invokes custom value caster', function () {
    $ValueCast = CustomCastClass::from([
        CustomCastClass::add_two => 1
    ]);
    expect($ValueCast->add_two)->toBeInt()
        ->and($ValueCast->add_two)->toBe(4);
});