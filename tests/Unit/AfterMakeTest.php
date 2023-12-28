<?php

use Zerotoprod\AppServiceModel\Tests\Models\AfterMakeClass;

test('after make', function () {
    expect(AfterMakeClass::from(['MyValue' => 'value'])->value_4)
        ->toBe('value');
});