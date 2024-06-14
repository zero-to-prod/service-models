<?php

use Zerotoprod\AppServiceModel\Tests\Models\NumberFormat;

test('formats a number', function () {
    $ValueCast = NumberFormat::make([
        NumberFormat::value => 3000
    ]);
    expect($ValueCast->value)->toBeString()
        ->and($ValueCast->value)->toBe('3.000,00');
});