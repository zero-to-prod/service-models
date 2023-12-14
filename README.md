# Service Models

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/service-models)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/zero-to-prod/service-model.svg)](https://packagist.org/packages/zero-to-prod/service-model)
![test](https://github.com/zero-to-prod/service-models/actions/workflows/php.yml/badge.svg)
![Downloads](https://img.shields.io/packagist/dt/zero-to-prod/service-model.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/zero-to-prod/service-model&#41)

A modern approach to [extensible](#extending-the-servicemodel-trait), [typesafe](#setting-up-your-model) DTOs
with [factory](#factories) support.

This **zero-dependency** package transforms associative arrays into nested, typesafe Data
Transfer [Objects](#setting-up-your-model) (DTOs).

## Features

- **Simple**: Use the `ServiceModel` [trait](#basic-implementation) to automatically map your data.
- **Custom Type Casting**: Define your own [casters](#custom-cast-for-one-to-one-cardinality) for infinite control.
- **`One-to-one`/`One-to-many`**: Easily define [cardinality](#custom-cast-for-one-to-many-cardinality) with attributes.
- **Factory Support**: Use the `factory()` [method](#factories) to make a DTO with default values.
- **Native Object Support**: [Native object support](#native-object-support) for [Enums](#enums)
  and [Classes](#classes), with no extra steps.
- **Fast**: Designed with [speed](#caching) and performance in mind.

## Getting Started

Install the `service-model` package with composer.

```bash
composer require zero-to-prod/service-model
```

Use the `ServiceModel` trait in your model.

Add properties to your model that match the keys of your data.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    public readonly int $id;
}
```

Pass an associative array to the `make()` method of your [model](#setting-up-your-model).

```php
$Order = Order::make(['id' => 1]);

$Order->id; // 1
```

Use the `factory()` method to make a new [model](#setting-up-your-model) with default values.

See the [Factories](#factories) section for more information.

```php
$order = Order::factory()->make();
$order->id; // 1
```

## Usage

Create a [model](#setting-up-your-model) by passing an associative array to the `make()` method of
your [model](#setting-up-your-model) that has the `ServiceModel` trait.

```php
$order = Order::make([
    'details' => ['id' => 1, 'name' => 'Order 1'],
    'status' => 'pending',
    'pickups' => [
        'location' => 'Location 1',
        'time' => '2021-01-01 00:00:00',
    ]
    'tags' => ['important', 'rush'],
    'ordered_at' => '2021-01-01 00:00:00',
    'items' => [
        Item::make(['id' => 1,'name' => 'Item 1']),
        ['id' => 2,'name' => 'Item 2']],
    'views' => [
        ['id' => 1,'name' => 'View 1'],
        ['id' => 2,'name' => 'View 2']],
]);
```

## Accessing Type Safe Properties

Access your data with the arrow syntax.

```php
$details = $order->details->name; // 'Order 1'
$status = $order->status; // Status::pending
$location = $order->pickups->location; // 'Location 1'
$tags = $order->tags[0]; // Tag::important
$ordered_at = $order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'
$item_id = $order->items[0]->id; // 1
$view_name = $order->views->first()->name; // 'View 1'
```

## Factory Support

Use the `factory()` method to make a new DTO with default values.

See the [Factories](#factories) section for more information.

```php
$order = Order::factory()->make();

$order->status; // Status::pending
```

## Basic Implementation

Define properties in your class to match the keys of your data.

The `ServiceModel` trait will automatically match the keys, detect the type, and cast the value.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    /**
     * Using the `ServiceModel` trait in OrderDetails
     * class will automatically map the data.
     */
    public OrderDetails $details;
}
```

> IMPORTANT: Use the `ServiceModel` trait in the child classes.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class OrderDetails
{
    use ServiceModel;

    public int $id;
    public string $name;
}
```

> NOTICE: The `details` key matches the `$details` property in `Order`.

```php
$order = Order::make([
    'details' => [
        'id' => 1, 
        'name' => 'Order 1'
    ],
]);

// This is also equivalent.
$order = Order::make([
    'details' => OrderDetail::make([
        'id' => 1, 
        'name' => 'Order 1'
    ]),
]);

$order->details->id; // 1
$order->details->name; // 'Order 1'
```

## Setting Up Your Model

Define properties in your class to match the keys of your data.

The `ServiceModel` trait will automatically match the keys, detect the type, and cast the value.

```php
use Zerotoprod\ServiceModel\ServiceModel;
use Zerotoprod\ServiceModel\Cast;
use Zerotoprod\ServiceModel\CastToArray;
use Zerotoprod\ServiceModel\CastToClasses;

class Order
{
    use ServiceModel;

    /**
     * Automatically cast OrderDetails to a model by using
     * the ServiceModel trait in OrderDetails.
     */
    public OrderDetails $details;
    
    /**
     * Use a value-backed enum to automatically cast the value.
     */
    public Status $status;
    
    /**
     * Unpacks the array into the constructor of the type-hinted class.
     */
    public readonly PickupInfo $pickups;
    
    /**
     * Casts to an array of PickupInfo.
     * @var PickupInfo[] $pickups
     */
    #[CastToClasses(PickupInfo::class)]
    public readonly array $pickups;
    
    /**
     * Casts to an array of enums.
     * @var Tag[] $tags
     */
    #[CastToArray(Tag::class)]
    public array $tags;

    /**
     * Custom cast for to transform the value into a Carbon instance.
     * @var Carbon $ordered_at
     */
    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;

    /**
     * Custom cast for an array of Items.
     * @var Item[] $items
     */
    #[CastToArray(Item::class)]
    public array $items;
    
    /**
     * Use a custom cast. 
     * @var Collection<int, View> $views
     */
    #[CastToCollection(View::class)]
    public array $views;
}
```

## Native Object Support

This package provides native support for the following objects:

- [Enums](#enums)
- [Classes](#classes)

### Enums

Use a value backed enum to automatically cast the value.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;
    
    /**
     * Casts to a Status enum
     */
    public Status $status;
    
    /**
     * Casts to an array of Status enum.
     * @var Status[] $statuses
     */
    #[CastToArray(Status::class)]
    public array $statuses;
}
```

```php
enum Status: string
{
    case pending = 'pending';
    case completed = 'completed';
}
```

```php
$order = Order::make([
    'status' => 'pending',
    'statuses' => ['pending', 'completed'],
]);

$order->status; // Status::pending
$order->status->value; // 'pending'

$order->statuses[0]; // Status::pending
$order->statuses[1]->value; // completed
```

### Classes

Sometimes you may want to cast to a class you cannot use the `ServiceModel` trait in.

For a `one-to-one` cast, simply typehint with the property with the class.
This will automatically unpack the array into the constructor of the class.

For a `one-to-many` cast, use the `CastToArray` attribute to cast an array of classes.

#### One-to-one

Simply typehint with the property with the class you want to cast to.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;
    
    /**
     * Unpacks the array into the constructor of the type-hinted class.
     */
    public readonly PickupInfo $pickups;
}
```

```php
class PickupInfo
{
    public function __construct(public readonly string $location, public readonly string $time)
    {
    }
}
```

```php
$order = Order::make([
    'pickups' => [
        'location' => 'Location 1',
        'time' => '2021-01-01 00:00:00',
    ]
]);

$order->pickups->location; // Location 1
$order->pickups->time; // 2021-01-01 00:00:00
```

#### One-to-many

Sometimes you may want to cast an array of classes you cannot use the `ServiceModel` trait.

Use the `CastToClasses` attribute to cast an array of classes.

```php
use Zerotoprod\ServiceModel\CastToClasses;
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;
    
    /**
     * Casts to an array of PickupInfo.
     * @var PickupInfo[] $pickups
     */
    #[CastToClasses(PickupInfo::class)]
    public readonly array $pickups;
}
```

```php
class PickupInfo
{
    public function __construct(public readonly string $location, public readonly string $time)
    {
    }
}
```

```php
$order = Order::make([
    'pickups' => [
        [
            'location' => 'Location 1',
            'time' => '2021-01-01 00:00:00',
        ],
        [
            'location' => 'Location 2',
            'time' => '2021-01-01 00:00:00',
        ],
    ],
]);

$order->pickups[0]->location; // Location 1
$order->pickups[0]->time; // 2021-01-01 00:00:00
```

## Custom Cast for `One-to-one` Cardinality

Implement the `CanCast` interface to make a custom type.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    /**
     * Transforms the value to a Carbon instance.
     */
    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;
```

```php
use Zerotoprod\ServiceModel\CanCast;

class ToCarbon implements CanCast
{
    public function set(array $value): Carbon
    {
        return Carbon::parse($value[0]);
    }
}
```

```php
$order = Order::make([
    'ordered_at' => '2021-01-01 00:00:00',
]);

$order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'
```

## Custom Cast for `One-to-many` Cardinality

Use the `CastToArray` attribute to cast an array of classes.

```php
use Zerotoprod\ServiceModel\ServiceModel;
use Illuminate\Support\Collection;

class Order
{
    use ServiceModel;

    /**
     * Casts to a Collection containing View classes.
     * @var Collection<int, View> $views
     */
    #[CastToCollection(View::class)]
    public Collection $views;
}
```

> IMPORTANT: The class name passed in the Attribute (`View::class`) is passed in the constructor of
> the `CastToCollection` class.

> IMPORTANT: Don't forget to add `#[Attribute]` to the top of your class.

```php
use Zerotoprod\ServiceModel\CanCast;

#[Attribute]
class CastToCollection implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set(array $value): Collection
    {
        return collect($value)->map(fn(array $item) => $this->class::make($item));
    }
}
```

```php
$order = Order::make([
    'views' => [
        [
            'id' => 1,
            'name' => 'View 1'
        ],
        [
            'id' => 2,
            'name' => 'View 2'
        ]
    ],
]);

$order->views->first()->name; // 'View 1'
```

## Factories

Factories provide a convenient way to generate DTOs with default values.

1. Use the `ServiceModel` and the  `HasFactory` trait in your model.
2. Create a class that `extends` the `Factory` class for your factory.
3. Set the `public string $model = ` property in your factory pointing to your model.
4. Set the `public static string $factory = ` property in your model pointing to your factory.
5. Return your default values as an array in the `definition()` method in your factory.

```php
use Zerotoprod\ServiceModel\HasFactory;
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;
    use HasFactory;

    public static string $factory = OrderFactory::class;
    
    public OrderDetails $details;
    public Status $status;
}
```

```php
use Zerotoprod\ServiceModel\Factory;

class OrderFactory extends Factory
{
    public string $model = Order::class;

    public function definition(): array
    {
        return [
            'details' => ['id' => 1, 'name' => 'Order 1'],
            'status' => 'pending',
        ];
    }

    public function setStatus(Status $status): self
    {
        return $this->state(fn() => [
            'status' => $status->value
        ]);
    }
}
```

```php
$order = Order::factory()->make();
$order->status; // Status::pending
$order->details->name; // 'Order 1'

$order = Order::factory()->setStatus(Status::completed)->make();
$order->status; // Status::completed
```

## Extending the `ServiceModel` Trait

You can extend the `ServiceModel` trait and add your own functionality to your models.

```php
<?php

namespace App\Channels\Amazon\ServiceModels\Support;

use Illuminate\Support\Collection;

trait ServiceModel
{
    use \Zerotoprod\ServiceModel\ServiceModel;

    public function toArray(): array
    {
        return $this->collect()->toArray();
    }

    public function toJson(): string
    {
        return $this->collect()->toJson();
    }

    public function collect(): Collection
    {
        return collect($this);
    }
}
```

This allows you to access custom methods on the model.

```php
Order::make([...])->toJson();
```

## Caching

The `ServiceModel` trait in this project uses an in-memory caching mechanism to improve performance. The caching is
implemented using
a Singleton pattern, which ensures that only a single instance of the cache is created and used throughout the
application.

The caching mechanism is used in the constructor of the ServiceModel trait. When an object is constructed,
the trait checks if a `ReflectionClass` instance for the current class already exists in the cache. If it doesn't, a new
`ReflectionClass` instance is created and stored in the cache.

The cache is also used when processing the properties of
the object. For each property, the trait checks if a `ReflectionProperty` instance and the property type name are
already
stored in the cache. If they aren't, they are retrieved using reflection and stored in the cache.