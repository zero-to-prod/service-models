<?php

use Zerotoprod\AppServiceModel\Tests\Models\Child;
use Zerotoprod\AppServiceModel\Tests\Models\TopLevelCastArray;

test('top level cast', function () {
    $TopLevelCast = TopLevelCastArray::make([
        TopLevelCastArray::children => [
            [Child::name => 'name'],
            [Child::name => 'name'],
        ]
    ]);

    expect($TopLevelCast->children)->toBeArray()
        ->and($TopLevelCast->children[0]->name)->toBe('name')
        ->and($TopLevelCast->children[0])->toBeInstanceOf(Child::class);
});
