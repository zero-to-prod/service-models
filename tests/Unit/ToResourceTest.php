<?php

use Zerotoprod\AppServiceModel\Tests\Models\MapOutputNamesClass;
use Zerotoprod\AppServiceModel\Tests\Models\MockEnumCast;
use Zerotoprod\AppServiceModel\Tests\Models\NestedOutputNamesClass;
use Zerotoprod\AppServiceModel\Tests\Models\ToResource;

test('snake case', function () {
    $MapOutputNamesClass = MapOutputNamesClass::from([
        MapOutputNamesClass::Name => 'Name',
        MapOutputNamesClass::LastName => 'LastName',
        MapOutputNamesClass::NestedOutputNamesClass => [
            NestedOutputNamesClass::Name => 'Name'
        ],
        MapOutputNamesClass::ArrayNestedOutputNamesClass => [
            [NestedOutputNamesClass::Name => 'Name'],
            [NestedOutputNamesClass::Name => 'Name']
        ],
        MapOutputNamesClass::Enum => MockEnumCast::first->value
    ]);

    $resource = $MapOutputNamesClass->toResource();

    expect($resource['name'])->toBe('Name')
        ->and($resource['last_name'])->toBe('LastName')
        ->and($resource['last_name'])->toBe('LastName')
        ->and($resource['nested_output_names_class']['name'])->toBe('Name')
        ->and($resource['enum'])->toBe(MockEnumCast::first->value)
        ->and($resource['array_nested_output_names_class'][0]['name'])->toBe('Name');
});

test('to resource', function () {
    $ToResource = ToResource::from([
        MapOutputNamesClass::Name => 'Name',
        MapOutputNamesClass::LastName => 'LastName',
        MapOutputNamesClass::NestedOutputNamesClass => [
            NestedOutputNamesClass::Name => 'Name'
        ],
        MapOutputNamesClass::ArrayNestedOutputNamesClass => [
            [NestedOutputNamesClass::Name => 'Name'],
            [NestedOutputNamesClass::Name => 'Name']
        ],
        MapOutputNamesClass::Enum => MockEnumCast::first->value
    ]);

    $resource = $ToResource->toResource();

    expect($resource['Name'])->toBe('Name')
        ->and($resource['LastName'])->toBe('LastName')
        ->and($resource['NestedOutputNamesClass']['Name'])->toBe('Name')
        ->and($resource['Enum'])->toBe(MockEnumCast::first->value)
        ->and($resource['ArrayNestedOutputNamesClass'][0]['Name'])->toBe('Name');
});
