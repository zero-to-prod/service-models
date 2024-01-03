<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\ExtensionClass;

test('extension', function () {
    $ExtensionClass = ExtensionClass::from([
        ExtensionClass::child => [
            Child::name => 'value',
        ]
    ]);

    expect($ExtensionClass->child->name)->toBe('value');
});