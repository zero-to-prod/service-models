<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\MockEnumCast;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCastArray;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCastArrayEnums;

test('top level cast', function () {
    $TopLevelCastArray = TopLevelCastArray::from([
        TopLevelCastArray::children => [
            [Child::name => 'name'],
            [Child::name => 'name'],
        ]
    ]);

    expect($TopLevelCastArray->children)->toBeArray()
        ->and($TopLevelCastArray->children[0]->name)->toBe('name')
        ->and($TopLevelCastArray->children[0])->toBeInstanceOf(Child::class);
});
test('top level cast with service model', function () {
    $TopLevelCastArray = TopLevelCastArray::from([
        TopLevelCastArray::children => [
            Child::from([Child::name => 'name']),
            [Child::name => 'name'],
        ]
    ]);

    expect($TopLevelCastArray->children)->toBeArray()
        ->and($TopLevelCastArray->children[0]->name)->toBe('name')
        ->and($TopLevelCastArray->children[0])->toBeInstanceOf(Child::class);
});
test('top level cast to enums values', function () {
    $TopLevelCastArrayEnums = TopLevelCastArrayEnums::from([
        TopLevelCastArrayEnums::children => [
            MockEnumCast::first->value,
            MockEnumCast::second,
        ]
    ]);

    expect($TopLevelCastArrayEnums->children)->toBeArray()
        ->and($TopLevelCastArrayEnums->children[0]->name)->toBe('first')
        ->and($TopLevelCastArrayEnums->children[0])->toBeInstanceOf(MockEnumCast::class)
        ->and($TopLevelCastArrayEnums->children[1]->name)->toBe('second')
        ->and($TopLevelCastArrayEnums->children[1])->toBeInstanceOf(MockEnumCast::class);
});