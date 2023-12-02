# Service Models

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/service-models)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/zero-to-prod/service-model.svg)](https://packagist.org/packages/zero-to-prod/service-model)
![Test](https://github.com/zero-to-prod/service-models/actions/workflows/php.yml/badge.svg)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/zero-to-prod/service-model.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/zero-to-prod/service-model&#41;)

Simple, extensible, typesafe DTOs.

This **zero-dependency** package transforms associative arrays into nested, typesafe Data Transfer Objects (DTOs). 

## Features

- **Simple**: Use the `ServiceModel` trait to automatically map your data.
- **Custom Type Casting**: Define your own casters for infinite control.
- **`HasOne`/`HasMany`**: Easily define relationships with attributes.
- **Factory Support**: Use the `factory()` method to make a DTO with default values.
- **Enum Support**: Cast enums directly, with no extra steps.

## Installation

```bash
composer require zero-to-prod/service-model
```

## Usage

Create a DTO by passing an associative array to the `make()` method of your model that has the `ServiceModel` trait.

```php
$order = Order::make([
    'details' => ['id' => 1, 'name' => 'Order 1'],
    'status' => 'pending',
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

## Implementation

Use the `ServiceModel` trait to automatically map and cast your data to properties in your models.

```php
use Zerotoprod\ServiceModel\ServiceModel;
use Zerotoprod\ServiceModel\Cast;
use Zerotoprod\ServiceModel\CastToArray;

class Order
{
    use ServiceModel;

    /**
     * Using the `ServiceModel` trait in OrderDetails
     * class will automatically map the data.
     */
    public OrderDetails $details;
    
    /**
     * Use a value-backed enum to automatically cast the value.
     */
    public Status $status;
    
    /**
     * Casts to an array of enums.
     * @var Tag[] $tags
     */
    #[CastToArray(Tag::class)]
    public array $tags;

    /**
     * Custom cast for a hasOne relationship.
     * @var Item[] $items
     */
    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;

    /**
     * Custom cast for a hasMany relationship.
     * @var Item[] $items
     */
    #[CastToArray(Item::class)]
    public array $items;
    
    /**
     * Use a custom hasMany cast. 
     * @var Collection<int, View> $views
     */
    #[CastToCollection(View::class)]
    public array $views;
}
```

## Basic Class Implementation

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

// this is also equivalent

$order = Order::make([
    'details' => OrderDetail::make([
        'id' => 1, 
        'name' => 'Order 1'
    ]),
]);

$order->details->id; // 1
$order->details->name; // 'Order 1'
```

## Enum Implementation

Use a value backed enum to automatically cast the value.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;
    
    public Status $status;
    
    /**
     * Casts to an array of enums.
     * @var Tag[] $tags
     */
    #[CastToArray(Tag::class)]
    public array $tags;
}
```

```php
enum Status: string
{
    case pending = 'pending';
    case completed = 'completed';
}

enum Tag: string
{
    case important = 'important';
    case rush = 'rush';
}
````

```php
$order = Order::make([
    'status' => 'pending',
    'tags' => ['important', 'rush'],
]);

$order->status; // Status::pending
$order->status->value; // 'pending'

$order->tags[0]; // Tag::important
$order->tags[0]->value; // 'important'
```

## Custom Cast for `HasOne` Relationships

Implement the `CanCast` interface to make a custom type.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    /**
     * Custom cast for a hasOne relationship.
     * @var Item[] $items
     */
    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;
```

```php
use Zerotoprod\ServiceModel\CanCast;

class ToCarbon implements CanCast
{
    public function set($value): Carbon
    {
        return Carbon::parse($value);
    }
}
```

```php
$order = Order::make([
    'ordered_at' => '2021-01-01 00:00:00',
]);

$order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'
```

## Custom Cast for `HasMany` Relationships

Implement a custom cast for a `hasMany` relationship.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    #[CastToCollection(View::class)]
    public Collection $views;
}
```

> IMPORTANT: The class name passed in the Attribute (`View::class`) is passed in the constructor of the `CastToCollection` class.

> IMPORTANT: Don't forget to add `#[Attribute]` to the top of your class.

```php
use Zerotoprod\ServiceModel\CanCast;

#[Attribute]
class CastToCollection implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set($value): Collection
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
