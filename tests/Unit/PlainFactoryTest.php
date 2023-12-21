<?php

use Zerotoprod\AppServiceModel\Tests\Models\PlainFactoryModel;

test('definition', function () {
    expect(PlainFactoryModel::factory()->make()->attributes['name'])
        ->toBe('definition');
});

test('definition override', function () {
    expect(PlainFactoryModel::factory()->setName('test')->make()->attributes['name'])
        ->toBe('test');
});