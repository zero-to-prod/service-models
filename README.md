# Service Models

Simple, typesafe DTOs.

## Introduction

This **zero-dependency** package provides a way to automatically create nested typesafe DTOs by using native PHP types
and attributes.

It's a convenient way to model nested data structures, offering a simple and effective way to add type safety to
your PHP applications. It utilizes attributes for casting and data transformations, making your code more readable and
maintainable.

## Features

- **Zero Dependency**: This package does not have any package dependencies.
- **ServiceModel Trait**: Simplifies the creation of service models.
- **Automatic Casting**: Attributes like `#[Cast]` and `#[CastToArray]` allow automatic type conversion.
- **Extensible**: Create your own casters for arrays and custom data types.

## Installation

```bash
composer require zero-to-prod/service-model
```

## Usage

### Defining Models

Use the `ServiceModel` trait in your classes to enable automatic casting.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    public OrderDetails $details;

    #[Cast(ToCarbon::class)]
    public Carbon $ordered_at;
    
    /**
     * @var Item[] $items
     */
    #[CastToArray(Item::class)]
    public array $items;
    
    /**
     * @var Collection<int, View> $views
     */
    #[CastToCollection(View::class)]
    public array $views;
}

class OrderDetails
{
    use ServiceModel;

    public int $id;
    public string $name;
}

class ToCarbon implements CanCast
{
    public function set($value): Carbon
    {
        return Carbon::parse($value);
    }
}

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

## Automatically Cast Nested Data

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
Access the properties directly from your model instances
```php
$details = $order->details;
$ordered_at = $order->ordered_at->toDateTimeString();
$item_id = $order->items[0]->id;
$view_name = $order->views->first()->name;
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
    public Collection $views;
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
