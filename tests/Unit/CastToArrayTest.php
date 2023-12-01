<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\MockEnumCast;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCastArray;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCastArrayEnums;

test('top level cast', function () {
    $TopLevelCastArray = TopLevelCastArray::make([
        TopLevelCastArray::children => [
            [Child::name => 'name'],
            [Child::name => 'name'],
        ]
    ]);

    expect($TopLevelCastArray->children)->toBeArray()
        ->and($TopLevelCastArray->children[0]->name)->toBe('name')
        ->and($TopLevelCastArray->children[0])->toBeInstanceOf(Child::class);
});
test('top level cast to enums', function () {
    $TopLevelCastArrayEnums = TopLevelCastArrayEnums::make([
        TopLevelCastArrayEnums::children => [
            MockEnumCast::first->value,
            MockEnumCast::second->value,
        ]
    ]);

    expect($TopLevelCastArrayEnums->children)->toBeArray()
        ->and($TopLevelCastArrayEnums->children[0]->name)->toBe('first')
        ->and($TopLevelCastArrayEnums->children[0])->toBeInstanceOf(MockEnumCast::class);
});