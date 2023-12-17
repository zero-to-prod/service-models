<?php

use Zerotoprod\AppServiceModel\Tests\Models\CastMethodClass;
use Zerotoprod\AppServiceModel\Tests\Models\TimeClass;

test('time value is cast to TimeClass instance', function () {
    expect(CastMethodClass::make([CastMethodClass::time => '2021-01-01 00:00:00'])
        ->time
    )->toBeInstanceOf(TimeClass::class);
});