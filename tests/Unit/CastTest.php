<?php /** @noinspection MissingIssetImplementationInspection */

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\AppServiceModel\Tests\Models\EmptyClass;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevel;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCast;
use Zerotoprod\AppServiceModel\Tests\Models\ValueCast;
use Zerotoprod\AppServiceModel\Tests\Models\WrongChild;

test('top level value cast', function () {
    $ValueCast = ValueCast::from([
        ValueCast::value => 3
    ]);
    expect($ValueCast->value)->toBeInt()
        ->and($ValueCast->value)->toBe(4);
});
test('empty class', function () {
    $EmptyClass = EmptyClass::from([
        'test' => 'value'
    ]);
    expect($EmptyClass)->toBeInstanceOf(EmptyClass::class)
        ->and(isset($EmptyClass->test))->toBeFalse();
});
test('top level cast', function () {
    $TopLevelCast = TopLevelCast::from([
        TopLevelCast::child => [
            ChildWithoutTrait::name => 'name'
        ]
    ]);
    expect($TopLevelCast->child)->toBeInstanceOf(ChildWithoutTrait::class)
        ->and($TopLevelCast->child->name)->toBe('name');
});
test('top level cast with service model', function () {
    $TopLevelCast = TopLevelCast::from([
        TopLevelCast::child => Child::from([Child::name => 'child name'])
    ]);
    expect($TopLevelCast->child)->toBeInstanceOf(ChildWithoutTrait::class)
        ->and($TopLevelCast->child->name)->toBe('child name');
});
test('cast service model', function () {
    $TopLevel = TopLevel::from([
        TopLevel::child => Child::from([Child::name => 'child name'])
    ]);

    expect($TopLevel->child)->toBeInstanceOf(Child::class)
        ->and($TopLevel->child->name)->toBe('child name');
});
test('cast wrong service model', function () {
    TopLevel::from([
        TopLevel::child => WrongChild::from([WrongChild::name => 'child name'])
    ]);
})->expectException(TypeError::class);