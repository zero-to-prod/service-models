<?php

use Zerotoprod\AppServiceModel\Tests\Models\FactoryModel;
use Zerotoprod\AppServiceModel\Tests\Models\FactoryModelChild;
use Zerotoprod\ServiceModel\Factory;

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
it('expand attributes', function () {
    $factory = new Factory;

    // Define a callable (not a string or array)
    $callableAttribute = function ($definition) {
        return count($definition) * 2;
    };

    // Invoke method via reflection as it's a protected method
    $reflection = new ReflectionClass(get_class($factory));
    $method = $reflection->getMethod('expandAttributes');
    $method->setAccessible(true);

    // Define a definition
    $definition = ['attribute' => $callableAttribute];

    // Invoke the method
    $result = $method->invokeArgs($factory, [$definition]);

    // Check if callable is called and calculated correct result
    expect($result)->toBeArray()
        ->and($result['attribute'])->toBe(2);
});
it('returns empty array for default definition of Factory', function () {
    $factory = new Factory();
    expect($factory->definition())->toBeArray()->toBeEmpty();
});