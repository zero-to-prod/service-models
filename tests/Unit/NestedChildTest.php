<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevel;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelWithoutChildTrait;

test('accesses child service model', function () {
    $TopLevel = TopLevel::make([
        TopLevel::child => [
            Child::name => 'name'
        ]
    ]);

    expect($TopLevel->child)->toBeInstanceOf(Child::class)
        ->and($TopLevel->child->name)->toBe('name');
});

test('type error service model without trait', function () {
    TopLevelWithoutChildTrait::make([
        TopLevelWithoutChildTrait::child => [
            ChildWithoutTrait::name => 'name'
        ]
    ]);
})->throws(TypeError::class);
