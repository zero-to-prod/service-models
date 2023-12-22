<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapFromDto;

test('map from', function () {
    $MapFromDto = MapFromDto::make(['MyValue' => 'value']);

    expect($MapFromDto->value_4)->toBe('value');
});