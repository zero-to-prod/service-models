# Service Models

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/service-models)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/zero-to-prod/service-model.svg)](https://packagist.org/packages/zero-to-prod/service-model)
![test](https://github.com/zero-to-prod/service-models/actions/workflows/php.yml/badge.svg)
![Downloads](https://img.shields.io/packagist/dt/zero-to-prod/service-model.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/zero-to-prod/service-model&#41)
[![codecov](https://codecov.io/gh/zero-to-prod/service-models/graph/badge.svg?token=A3PT9316HO)](https://codecov.io/gh/zero-to-prod/service-models)

A modern approach to [extensible](#extending-the-servicemodel-trait), [typesafe](#setting-up-your-model) Data Transfer
Objects (DTOs)
with [factory](#factories) support.

This [zero-dependency](https://raw.githubusercontent.com/zero-to-prod/service-models/master/composer.json) package
provides a [way](#getting-started) to [serialize](https://en.wikipedia.org/wiki/Serialization) associative arrays into
typesafe [DTOs](#setting-up-your-model).

In the [Extract Transform Load](https://en.wikipedia.org/wiki/Extract,_transform,_load) (ETL) process, this package
assist in the **_Transformation_** of data into a model.

## Features

- **Simple**: Use the `ServiceModel` [trait](#basic-implementation) to automatically map your data.
- **Custom Type Casting**: Define your own value [casters](#value-casting) for infinite control.
- **Plugin Architecture**: Build your own [plugins](#plugins) with PHP Attributes.
- **Nested Relationships**: Easily define [one-to-many](#one-to-many-casting) relationships with native PHP attributes.
- **Mapping**: Rename and [map](#mapping) your data how you please.
- **Factory Support**: Use the `factory()` [method](#factories) to make a DTO with default values.
- **Native Object Support**: [Native object support](#native-object-support) for [Enums](#enums)
  and [Classes](#classes), with no extra steps.
- **Resource Support**: Transform you ServiceModel to an associative array with [snake_case](#resource-support) keys or
  implement your own.
- **Fast**: Designed with [performance](#caching) in mind.

## Getting Started

If upgrading from v1, see the [upgrade guide](#upgrading-to-v2).

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

Create a [model](#setting-up-your-model) instance by passing an associative array to the `make()` method of
your model that uses the `ServiceModel` trait.

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
// Nested Models
$details = $order->details; // Order::class
$details = $order->details->name; // 'Order 1'

// Enums
$status = $order->status; // Status::pending
$status = $order->status->value; // 'pending'

// Nested Enums
$tags = $order->tags[0]; // Tag::important
$tags = $order->tags[0]->value; // 'important'

// Value Casting
$ordered_at = $order->ordered_at; // Carbon::class
$ordered_at = $order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'

// One-to-many array Casting
$item_id = $order->items[0]; // Item::class
$item_id = $order->items[0]->id; // 1

// One-to-many custom Casting
$view_name = $order->views->first(); // View::class
$view_name = $order->views->first()->name; // 'View 1'
```

## Factory Support

Use the `factory()` method to make a new model instance with default values.

See the [Factories](#factories) section for how to set up and use factories.

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
     * Using the `ServiceModel` trait in the child class (OrderDetails)
     * class will automatically instantiate new class.
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
use Zerotoprod\ServiceModel\Attributes\Cast;use Zerotoprod\ServiceModel\Attributes\CastToArray;use Zerotoprod\ServiceModel\Attributes\CastToClasses;use Zerotoprod\ServiceModel\ServiceModel;

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
     * Because Carbon uses the static method `parse`, this will 
     * cast the value to a Carbon instance for free.
     */
    public readonly Carbon $created_at;

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
    public Collection $views;
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

For a simple cast, simply typehint with the property with the class.
This will automatically unpack the array into the constructor of the class.

For a `one-to-many` cast, use the `CastToArray` attribute to cast an array of classes.

#### Simple Class Casting

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

$order->pickups; // PickupInfo::class
$order->pickups->location; // Location 1
$order->pickups->time; // 2021-01-01 00:00:00
```

#### Using a Class Method for Parsing

In some cases, you might have a class with a method that accepts a value and returns an instance of the class itself.

The `ServiceModel` package allows you to leverage such methods for parsing values.

You can specify the method to be used for parsing by applying the `CastMethod` attribute to the property in your model.
The attribute takes the name of the method as its argument.

Here's an example:

```php

use Zerotoprod\ServiceModel\Attributes\CastMethod;
use Zerotoprod\ServiceModel\ServiceModel;

class CastMethodClass
{
    use ServiceModel;

    // The 'set' method of the TimeClass will be used for parsing the value
    #[CastMethod('set')]
    public TimeClass $time;
}
```

In the `TimeClass` below, the `set` method accepts a value, assigns it to the `value` property of a new `TimeClass`
instance, and then returns the instance:

```php
class TimeClass
{
    public string $value;

    public static function set($value): self
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }
}
```

In this exampleWhen the `ServiceModel` trait processes the `time` property of the `CastMethodClass`, it will invoke
the `set` method of the `TimeClass`, passing the value to be parsed. The method will return a `TimeClass` instance,
which will then be assigned to the `time` property.

#### One-to-many Class Casting

Sometimes you may want to cast an array of classes you cannot use the `ServiceModel` trait in.

Use the `CastToClasses` attribute to cast an array of classes.

```php
use Zerotoprod\ServiceModel\Attributes\CastToClasses;use Zerotoprod\ServiceModel\ServiceModel;

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

## Value Casting

Implement the `CanCast` interface to make a custom type.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class Order
{
    use ServiceModel;

    /**
     * Transforms the value to a custom instance.
     */
    #[Cast(ToCustomTime::class)]
    public readonly ToCustomTime $ordered_at;

    /**
     * Because Carbon uses the static method `parse`, this will 
     * cast the value to a Carbon instance for free.
     */
    public readonly Carbon $created_at;
```

```php
use Zerotoprod\ServiceModel\Contracts\CanParse;

class ToCustomTime implements CanParse
{
    public function parse(array $values): Carbon
    {
        return ToCustomTime::parse($values[0]);
    }
}
```

```php
$order = Order::make([
    'ordered_at' => '2021-01-01 00:00:00',
    'created_at' => '2021-01-01 00:00:00',
]);

$order->ordered_at; // Carbon::class
$order->ordered_at->toDateTimeString(); // '2021-01-01 00:00:00'

$order->created_at; // Carbon::class
$order->created_at->toDateTimeString(); // '2021-01-01 00:00:00'
```

## `One-to-many` Casting

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
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CastToCollection implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): Collection
    {
        return collect($values)->map(fn(array $item) => $this->class::make($item));
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

$order->views->first(); // View::class
$order->views->first()->name; // 'View 1'
```

## Plugins

You can define your own attributes to extend the functionality of the `ServiceModel` trait.

The property values are passed to the `parse()` method of the attribute.

The Attribute values are passed to the constructor of the attribute.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class MyClass
{
    use ServiceModel;

    #[CustomCaster(1)]
    public readonly int $add_one;
    
    #[CustomValueCaster(1, 2)]
    public readonly int $add_two;
}
```

```php
$MyClass = MyClass::make(['add_one' => 1, 'add_two' => 1]);
$MyClass->add_one; // 2
$MyClass->add_two; // 4
```

```php
use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CustomCaster implements CanParse
{
    public function __construct(public readonly int $attribute_constructor_value)
    {
    }

    public function parse(array $values): int
    {
        return $values[0] + $this->attribute_constructor_value;
    }
}
```

```php
use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CustomValueCaster implements CanParse
{
    public function __construct(public readonly int $value_1, public readonly int $value_2)
    {
    }

    public function parse(array $values): int
    {
        return $values[0] + $this->value_1 + $this->value_2;
    }
}
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

## Mapping

The #[MapFrom] attribute allows you to associate a property from a DTO (Data Transfer Object) with another property that
possesses a different name.

This association is achievable using either a "dot" notation property name or an index.

### Renaming

The following example shows how to rename a property using the `#[MapFrom]` attribute.

```php
use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\ServiceModel;

class MyClass
{
    use ServiceModel;

    #[MapFrom('MyValue')]
    public readonly string $my_value;
}
```

```php
$MyClass = MyClass::make(['MyValue' => 'value']);
$MyClass->my_value; // 'value'
```

### Mapping Nested Properties

The following example shows how to map a nested property using the `#[MapFrom]` attribute.

```php
use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\ServiceModel;

class MyClass
{
    use ServiceModel;

    #[MapFrom('value.nested')]
    public readonly string $value;
}
```

```php
$MyClass = MyClass::make(['value' => ['nested' => 'value']]);
$MyClass->value; // 'value'
```

## Lifecycle Hooks

Use the `afterMake()` method to run code after the model is instantiated.

The `$attributes` parameter is the value passed to the `make()` method.

```php
use Zerotoprod\ServiceModel\ServiceModel;

class MyClass
{
    use ServiceModel;

    public readonly string $value;
    
    public function afterMake($attributes): void
    {
        // Example of manual assignment.
        $this->value = $attributes['Value'];
    }
}
```

## Caching

The `ServiceModel` trait in this project uses an in-memory caching mechanism to improve performance. The caching is
implemented using a Singleton pattern, which ensures that only a single instance of the cache is created and used
throughout the application.

The caching mechanism is used in the constructor of the ServiceModel trait. When an object is constructed, the trait
checks if a `ReflectionClass` instance for the current class already exists in the cache. If it doesn't, a
new `ReflectionClass` instance is created and stored in the cache.

The cache is also used when processing the properties of the object. For each property, the trait checks if
a `ReflectionProperty` instance and the property type name are already stored in the cache. If they aren't, they are
retrieved using reflection and stored in the cache.

## Resource Support

Sometimes you want to convert the case of your key to snake_case.

You can do this by adding the `#[MapOutputNames(ToSnakeCase::class)]` attribute to your model and using
the `toResource()` method.

```php
use Zerotoprod\ServiceModel\Attributes\MapOutputNames;
use Zerotoprod\ServiceModel\Attributes\ToSnakeCase;
use Zerotoprod\ServiceModel\ServiceModel;

#[MapOutputNames(ToSnakeCase::class)]
class MyClass
{
    use ServiceModel;

    public readonly string $LastName;
}
```

```php
$MyClass = MyClass::make(['LastName' => 'Doe']);
$MyClass->toResource(); // ['last_name' => 'Doe']
```

### Build Your Own Resource Transformer

You can build your own resource transformer by doing this implementing the `CanParse` interface.

The `$values` parameter is the value of the object typecast as an array.

```php
use Attribute;
use UnitEnum;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class ToCustomCase implements CanParse
{
    public function parse(array $values): array
    {
        return $values;
    }
}
```

You can add this to the top of your model like this:

```php
use Zerotoprod\ServiceModel\Attributes\MapOutputNames;
use Zerotoprod\ServiceModel\ServiceModel;

#[MapOutputNames(ToCustomCase::class)]
class MyClass
{
    use ServiceModel;

    public readonly string $LastName;
}
```

When you call the `toResource()` method, it will use your custom resource transformer.

## Upgrading to v2

This guide will help you upgrade your existing codebase to use the new features and improvements in the latest version
of the Service Models package

1. **Update the Package**

```shell
composer update zero-to-prod/service-model
```

2. **Update Attribute Namespaces**

The namespaces for the attributes have changed. Update your import statements to reflect these changes:

> IMPORTANT: The namespace for attributes have moved from `Zerotoprod\ServiceModel`
> to `Zerotoprod\ServiceModel\Attributes`.

**Before:**

```php
use Zerotoprod\ServiceModel\Cast;
use Zerotoprod\ServiceModel\CastToArray;
use Zerotoprod\ServiceModel\CastToClasses;
use Zerotoprod\ServiceModel\CanCast;
```

**After:**

```php
use Zerotoprod\ServiceModel\Attributes\Cast;
use Zerotoprod\ServiceModel\Attributes\CastToArray;
use Zerotoprod\ServiceModel\Attributes\CastToClasses;
use Zerotoprod\ServiceModel\Contracts\CanParse;
```

3. **Update Caster Interface**

The `CanCast` interface has been replaced with `CanParse`. Update your classes that implement this interface:

> IMPORTANT: The `CanCast` interface has been replaced with `CanParse`.
**Before:**

```php
use Zerotoprod\ServiceModel\CanCast;
```

**After:**

```php
use Zerotoprod\ServiceModel\Contracts\CanParse;
```

4. **Update Caster Method Names**

The method names in classes implementing the caster interface have changed from `set` to `parse`. Update these methods
in your classes:

> IMPORTANT: The `set` method has been replaced with `parse`.

**Before:**

```php
use Zerotoprod\ServiceModel\CanCast;

class ToCarbon implements CanCast
{
    public function set(array $values): Carbon
    {
        return Carbon::parse($values[0]);
    }
}
```

**After:**

```php
use Zerotoprod\ServiceModel\Contracts\CanParse;

class ToCarbon implements CanParse
{
    public function parse(array $values): Carbon
    {
        return Carbon::parse($values[0]);
    }
}
```

**Before:**

```php
use Zerotoprod\ServiceModel\CanCast;

#[Attribute]
class CastToCollection implements CanCast
{
    public function __construct(public readonly string $class)
    {
    }

    public function set(array $values): Collection
    {
        return collect($values)->map(fn(array $item) => $this->class::make($item));
    }
}
```

**After:**

```php
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CastToCollection implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): Collection
    {
        return collect($values)->map(fn(array $item) => $this->class::make($item));
    }
}
```

Please test your application thoroughly after making these changes to ensure everything works as expected.
