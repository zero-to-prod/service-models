<?php

use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\Carbon;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\Item;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\Order;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\OrderDetails;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\PickupInfo;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\Status;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\TimeClass;
use Zerotoprod\AppServiceModel\Tests\Models\SmokeTest\View;

test('smoke test', function () {
    $items = [
        Order::details => [
            OrderDetails::id => 1,
            OrderDetails::name => 'Order 1',
        ],
        Order::metadata => [
            OrderDetails::id => 1,
            OrderDetails::name => 'Order 1',
        ],
        Order::time => '2021-01-01 00:00:00',
        'AcknowledgedAt' => '2021-01-01 00:00:00',
        'vendor_details' => [
            'serial_number' => '1234567890'
        ],
        Order::status => 'pending',
        Order::statuses => ['pending', 'completed'],
        Order::PickupInfo => [
            PickupInfo::location => 'Location 1',
            PickupInfo::time => '2021-01-01 00:00:00',
        ],
        Order::previous_pickups => [
            [
                PickupInfo::location => 'Location 2',
                PickupInfo::time => '2021-01-02 00:00:00',
            ],
            [
                PickupInfo::location => 'Location 3',
                PickupInfo::time => '2021-01-03 00:00:00',
            ],
        ],
        Order::created_at => '2021-01-01 00:00:00',
        Order::items => [
            Item::make([
                Item::id => 1,
                Item::name => 'Item 1'
            ]),
            [
                Item::id => 2,
                Item::name => 'Item 2'
            ]
        ],
        Order::views => [
            [
                View::id => 1,
                View::name => 'View 1'
            ],
            [
                View::id => 2,
                View::name => 'View 2'
            ]
        ]
    ];

    $Order = Order::make($items);

    expect($Order->details)->toBeInstanceOf(OrderDetails::class)
        ->and($Order->details->id)->toBe(1)
        ->and($Order->details->name)->toBe('Order 1')
        ->and($Order->metadata)->toBeString()
        ->and($Order->metadata)->toBe('{"id":1,"name":"Order 1"}')
        ->and($Order->time)->toBeInstanceOf(TimeClass::class)
        ->and($Order->time->value)->toBe('2021-01-01 00:00:00')
        ->and($Order->acknowledged_at)->toBe('2021-01-01 00:00:00')
        ->and($Order->status->value)->toBe('pending')
        ->and($Order->statuses[0])->toBeInstanceOf(Status::class)
        ->and($Order->statuses[0]->value)->toBe('pending')
        ->and($Order->statuses[1])->toBeInstanceOf(Status::class)
        ->and($Order->statuses[1]->value)->toBe('completed')
        ->and($Order->PickupInfo)->toBeInstanceOf(PickupInfo::class)
        ->and($Order->PickupInfo->location)->toBe('Location 1')
        ->and($Order->PickupInfo->time)->toBe('2021-01-01 00:00:00')
        ->and($Order->previous_pickups[0])->toBeInstanceOf(PickupInfo::class)
        ->and($Order->previous_pickups[0]->location)->toBe('Location 2')
        ->and($Order->previous_pickups[0]->time)->toBe('2021-01-02 00:00:00')
        ->and($Order->previous_pickups[1])->toBeInstanceOf(PickupInfo::class)
        ->and($Order->previous_pickups[1]->location)->toBe('Location 3')
        ->and($Order->previous_pickups[1]->time)->toBe('2021-01-03 00:00:00')
        ->and($Order->created_at)->toBeInstanceOf(Carbon::class)
        ->and($Order->created_at->time)->toBe('2021-01-01 00:00:00')
        ->and($Order->items[0])->toBeInstanceOf(Item::class)
        ->and($Order->items[0]->id)->toBe(1)
        ->and($Order->items[0]->name)->toBe('Item 1')
        ->and($Order->items[1])->toBeInstanceOf(Item::class)
        ->and($Order->items[1]->id)->toBe(2)
        ->and($Order->items[1]->name)->toBe('Item 2')
        ->and($Order->views->first())->toBeInstanceOf(View::class)
        ->and($Order->views->first()->id)->toBe(1)
        ->and($Order->views->first()->name)->toBe('View 1');
});