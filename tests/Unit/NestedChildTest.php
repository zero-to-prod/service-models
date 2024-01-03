<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevel;

test('accesses child service model', function () {
    $TopLevel = TopLevel::from([
        TopLevel::child => [
            Child::name => 'name'
        ]
    ]);

    expect($TopLevel->child)->toBeInstanceOf(Child::class)
        ->and($TopLevel->child->name)->toBe('name');
});
