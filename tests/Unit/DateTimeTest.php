<?php

use Zerotoprod\AppServiceModel\Tests\Models\DateTimeModel;

test('top level value cast', function () {
    expect(DateTimeModel::make([DateTimeModel::time => '2021-01-01 00:00:00'])->time)
        ->toBeInstanceOf(DateTime::class);
});