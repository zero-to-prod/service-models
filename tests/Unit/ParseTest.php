<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastUsingClass;
use Zerotoprod\AppServiceModel\Tests\Models\TimeClass;

test('time value is cast to TimeClass instance', function () {
    expect(CastUsingClass::make([CastUsingClass::time => '2021-01-01 00:00:00'])
        ->time
    )->toBeInstanceOf(TimeClass::class);
});