<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapFromDto;

test('map from', function () {
    $MapFromDto = MapFromDto::make(['value_1' => 'test1']);

    expect($MapFromDto->value_4)->toBe('test1');
});