<?php

use Zerotoprod\AppServiceModel\Tests\Models\FactoryModel;
use Zerotoprod\AppServiceModel\Tests\Models\FactoryModelChild;

test('definition', function () {
    $FactoryModel = FactoryModel::factory()->make();

    expect($FactoryModel->name)
        ->toBe('definition')
        ->and($FactoryModel->Child->name)
        ->toBe('child')
        ->and($FactoryModel->Child)
        ->toBeInstanceOf(FactoryModelChild::class);
});

test('factory', function () {
    $FactoryModel = FactoryModel::factory([
        FactoryModel::name => 'name'
    ])->make();

    expect($FactoryModel->name)->toBe('name');
});

test('factory make', function () {
    $FactoryModel = FactoryModel::factory()
        ->make([
            FactoryModel::name => 'name'
        ]);

    expect($FactoryModel->name)->toBe('name');
});

test('overridden', function () {
    $FactoryModel = FactoryModel::factory([
        FactoryModel::name => 'name'
    ])->setName('overridden')->make();

    expect($FactoryModel->name)->toBe('overridden');
});

test('overridden make', function () {
    $FactoryModel = FactoryModel::factory()
        ->setName('overridden')
        ->make([
            FactoryModel::name => 'name'
        ]);

    expect($FactoryModel->name)->toBe('name');
});
