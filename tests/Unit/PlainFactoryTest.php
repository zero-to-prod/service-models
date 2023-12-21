<?php

use Zerotoprod\AppServiceModel\Tests\Models\PlainFactoryModel;

test('definition', function () {
    expect(PlainFactoryModel::factory()->make()->attributes['name'])
        ->toBe('definition');
});