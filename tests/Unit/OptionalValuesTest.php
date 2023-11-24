<?php

use Zerotoprod\AppServiceModel\Tests\Models\OptionalValues;

test('optional values', function () {
    $Mock = OptionalValues::make();

    expect($Mock->int)->toBeNull()
        ->and($Mock->float)->toBeNull()
        ->and($Mock->string)->toBeNull()
        ->and($Mock->bool)->toBeNull()
        ->and($Mock->array)->toBeNull()
        ->and($Mock->object)->toBeNull();
});