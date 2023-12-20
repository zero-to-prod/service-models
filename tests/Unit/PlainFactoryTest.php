<?php

use Zerotoprod\AppServiceModel\Tests\Models\FactoryModel;
use Zerotoprod\AppServiceModel\Tests\Models\FactoryModelChild;
use Zerotoprod\AppServiceModel\Tests\Models\PlainFactoryModel;

test('definition', function () {
    $FactoryModel = PlainFactoryModel::factory()->make();

    expect($FactoryModel->name)
        ->toBe('definition')
        ->and($FactoryModel->Child->name)
        ->toBe('child')
        ->and($FactoryModel->Child)
        ->toBeInstanceOf(FactoryModelChild::class);
});

test('factory', function () {
    $FactoryModel = PlainFactoryModel::factory([
        FactoryModel::name => 'name'
    ])->make();

    expect($FactoryModel->name)->toBe('name');
});

test('factory make', function () {
    $FactoryModel = PlainFactoryModel::factory()
        ->make([
            FactoryModel::name => 'name'
        ]);

    expect($FactoryModel->name)->toBe('name');
});

test('overridden', function () {
    $FactoryModel = PlainFactoryModel::factory([
        FactoryModel::name => 'name'
    ])->setName('overridden')->make();

    expect($FactoryModel->name)->toBe('overridden');
});

test('overridden make', function () {
    $FactoryModel = PlainFactoryModel::factory()
        ->setName('overridden')
        ->make([
            FactoryModel::name => 'name'
        ]);

    expect($FactoryModel->name)->toBe('name');
});
