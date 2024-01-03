<?php

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    public const details = 'details';
    public const metadata = 'metadata';
    public const time = 'time';
    public const acknowledged_at = 'acknowledged_at';
    public const serial_number = 'serial_number';
    public const status = 'status';
    public const statuses = 'statuses';
    public const PickupInfo = 'PickupInfo';
    public const previous_pickups = 'previous_pickups';
    public const created_at = 'created_at';
    public const items = 'items';
    public const views = 'views';
    public readonly OrderDetails $details;
    #[Describe(['from' => ToJson::class])]
    public readonly string $metadata;

    #[Describe(['via' => 'set'])]
    public readonly TimeClass $time;

    #[Describe(['map_from' => 'AcknowledgedAt'])]
    public readonly string $acknowledged_at;

    #[Describe(['map_from' => 'vendor_details.serial_number'])]
    public readonly string $serial_number;

    public readonly Status $status;

    /* @var Status[] $statuses */
    #[Describe(['from' => Status::class])]
    public array $statuses;

    /**
     * Unpacks the array into the constructor of the type-hinted class.
     */
    public readonly PickupInfo $PickupInfo;

    /**
     * Casts to an array of PickupInfo.
     * NOTE: PickupInfo does not use the ServiceModel trait.
     *
     * @var PickupInfo[] $pickups
     */
    #[Describe(['from' => PickupInfo::class])]
    public readonly array $previous_pickups;

    /**
     * Because Carbon uses the static method `parse`, this will
     * cast the value to a Carbon instance for free.
     */
    public readonly Carbon $created_at;

    /**
     * Creates an array of Items.
     * @var Item[] $items
     */
    #[Describe(['from' => Item::class])]
    public readonly array $items;

    /**
     * Use a custom cast.
     * @var Collection<int, View> $views
     */
    public readonly Collection $views;
}