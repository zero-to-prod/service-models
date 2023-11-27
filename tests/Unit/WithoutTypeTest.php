<?php

use Zerotoprod\AppServiceModel\Tests\Models\WithoutType;

test('without type', function () {
    $WithoutType = WithoutType::make([
        WithoutType::name => 'name'
    ]);
    expect($WithoutType->name)->toBeString()
        ->toBe('name');
});
