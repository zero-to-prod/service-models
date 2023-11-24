<?php

use Zerotoprod\AppServiceModel\Tests\Models\ChildWithoutTrait;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCast;

test('top level cast', function () {
    $TopLevelCast = TopLevelCast::make([
        TopLevelCast::child => [
            ChildWithoutTrait::name => 'name'
        ]
    ]);
    expect($TopLevelCast->child)->toBeInstanceOf(ChildWithoutTrait::class)
        ->and($TopLevelCast->child->name)->toBe('name');
});
