# Service Models

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/service-models)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/zero-to-prod/service-model.svg)](https://packagist.org/packages/zero-to-prod/service-model)
![Test](https://github.com/zero-to-prod/service-models/actions/workflows/php.yml/badge.svg)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/zero-to-prod/service-model.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/zero-to-prod/service-model&#41;)

Simple, extensible, typesafe DTOs.

This **zero-dependency** package transforms associative arrays into nested, typesafe Data Transfer Objects (DTOs). 

Types assigned to properties on your models are used to automatically map and cast your data to type-safe structures.

- **Simple**: Use the `ServiceModel` trait  for automatic data-to-model mapping.
- **Native Type Casting**: Automatically cast values by defining a type on a property.
- **Custom Type Casting**: Define your own casters for infinite control.
- **One-to-One/One-to-Many Relationships**: Easily define relationsihips with attributes.
- **Enum Support**: Cast enums directly, with no extra steps.

## Installation

```bash
composer require zero-to-prod/service-model
```

## Usage

Create a DTO by passing an associative array to the `make()` method of your model.

```php
$order = Order::make([
    'details' => ['id' => 1, 'name' => 'Order 1'],
    'status' => 'pending',
    'ordered_at' => '2021-01-01 00:00:00',
    'items' => [
        ['id' => 1,'name' => 'Item 1'],
        ['id' => 2,'name' => 'Item 2']],
    'views' => [
        ['id' => 1,'name' => 'View 1'],
        ['id' => 2,'name' => 'View 2']],
]);
```

## Accessing Type Safe Properties

Access properties directly from your models.

```php
$details = $order->details->name; // 'Order 1'
$ordered_at = $order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'
$item_id = $order->items[0]->id; // 1
$view_name = $order->views->first()->name; // 'View 1'
```

## Implementation

Pull in the `ServiceModel` trait in your classes to automatically map and cast your data to properties on your models.

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
     * Custom cast for a one-to-one relationship.
     * @var Item[] $items
     */
    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;

    /**
     * Custom cast for a one-to-many relationship.
     * @var Item[] $items
     */
    #[CastToArray(Item::class)]
    public array $items;
    
    /**
     * Create your own one-to-many casts. 
     * @var Collection<int, View> $views
     */
    #[CastToCollection(View::class)]
    public array $views;
}
```

## Basic Class Implementation

Define properties on your class that match the keys in your data. The `ServiceModel` trait will automatically map the
data onto your properties.

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

```php
use Zerotoprod\ServiceModel\ServiceModel;

class OrderDetails
{
    use ServiceModel;

    public int $id;
    public string $name;
}
```

```php
$order = Order::make([
    'details' => ['id' => 1, 'name' => 'Order 1'],
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
}
```

```php
enum Status: string
{
    case pending = 'pending';
    case completed = 'completed';
}
````

```php
$order = Order::make([
    'status' => 'pending',
]);

$order->status; // Status::pending
$order->status->value; // 'pending'
```

## Custom Cast for One-to-One Relationships

Implement custom casting logic using classes that implement the `CanCast` interface.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    /**
     * Custom cast for a one-to-one relationship.
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

## Custom Cast for One-to-Many Relationships

Implement a custom cast for a one-to-many relationship.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    #[CastToCollection(View::class)]
    public Collection $views;
}
```

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
        ['id' => 1,'name' => 'View 1'],
        ['id' => 2,'name' => 'View 2']],
]);

$order->views->first()->name; // 'View 1'
```
