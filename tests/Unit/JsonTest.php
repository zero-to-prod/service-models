<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevel;

test('json', function () {
    $data = [
        TopLevel::child => [
            Child::name => 'value',
        ]
    ];

    $TopLevel = TopLevel::from(json_encode($data));

    expect($TopLevel->child->name)->toBe('value');
});

test('invalid json', function () {
    expect(empty(TopLevel::from('name')->child->name))->toBeTrue();
});