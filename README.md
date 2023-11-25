# Service Models

Simple, extensible, typesafe DTOs.

## Introduction

This **zero-dependency** package turns **associative arrays** into nested, **typesafe** Data Transfer Objects (DTOs). It utilizes **native** PHP types and attributes to automatically map your data onto the properties of your models.

## Features

- **Simple**: Seamlessly integrate the `ServiceModel` trait into any class for automatic data-to-model mapping.
- **Native Type Casting**: Automatically cast your data by defining a type on a property.
- **Custom Casts**: Easily define custom types or remap existing ones using PHP attributes.
- **Enum Support**: Cast enums directly, with no extra steps.

## Installation

```bash
composer require zero-to-prod/service-model
```

## Usage

You can create instances of your models using the `make()` method.

```php
$order = Order::make([
    'details' => ['id' => 1, 'name' => 'Order 1'],
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
Access the properties directly from your model instances.
```php
$details = $order->details;
$ordered_at = $order->ordered_at->toDateTimeString();
$item_id = $order->items[0]->id;
$view_name = $order->views->first()->name;
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
     * Using the `ServiceModel` trait in the 
     * OrderDetails class will automatically 
     * map the data.
     */
    public OrderDetails $details;

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

use Zerotoprod\ServiceModel\ServiceModel;

class OrderDetails
{
    use ServiceModel;

    public int $id;
    public string $name;
}

use Zerotoprod\ServiceModel\CanCast;

class ToCarbon implements CanCast
{
    public function set($value): Carbon
    {
        return Carbon::parse($value);
    }
}

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
## Custom Cast

Implement custom casting logic using classes that implement the `CanCast` interface.

```php
class ToCarbon implements CanCast
{
    public function set($value): Carbon
    {
        return Carbon::parse($value);
    }
}
```
## Custom Cast for Collections/Arrays

You can decorate your class properties with a custom caster for collections/arrays like this:

```php
class Order
{
    use ServiceModel;

    #[CastToCollection(View::class)]
    public array $views;
}
```

```php
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
