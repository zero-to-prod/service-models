<?php

namespace Zerotoprod\ServiceModel;

use ReflectionClass;

trait ServiceModel
{
    public function __construct(mixed $items = null)
    {
        if (!$items || !(is_array($items) || is_object($items))) {
            return;
        }

        $Cache = Cache::getInstance();
        $ReflectionClass = $Cache->remember(static::class, fn() => new ReflectionClass($this));

        foreach ($items as $key => $value) {
            if (!$ReflectionClass->hasProperty($key)) {
                continue;
            }

            $cache_key = static::class . '::' . $key;
            $ReflectionProperty = $Cache->remember($cache_key, fn() => $ReflectionClass->getProperty($key));
            $model_classname = $Cache->remember($cache_key . '::type',
                fn() => $ReflectionProperty->getType()?->getName() ?? 'string'
            );
            $ReflectionAttribute = $ReflectionProperty->getAttributes()[0] ?? null;

            if (!$ReflectionAttribute) {
                // One-to-One Cast
                if ($Cache->remember($model_classname . '::method_exists',
                    fn() => method_exists($model_classname, 'make'))
                ) {
                    $this->{$key} = $model_classname::make($value);
                    continue;
                }

                // Enums: pass enum directly.
                if (isset($value->value)) {
                    $this->{$key} = $model_classname::tryFrom($value->value);
                    continue;
                }

                // Enums: tryFrom() value.
                if ($Cache->remember($model_classname . '::enum_exists',
                    fn() => enum_exists($model_classname))
                ) {
                    $this->{$key} = $model_classname::tryFrom($value);
                    continue;
                }

                // Plain classes
                if ($Cache->remember($model_classname . '::class_exists',
                    fn() => class_exists($model_classname))
                ) {
                    // One-to-many plain class
                    if (is_array($value)) {
                        $this->{$key} = new $model_classname(...$value);
                        continue;
                    }
                    // One-to-one plain class
                    $this->{$key} = new $model_classname($value);
                    continue;
                }

                // Native types
                $this->{$key} = $value;
                continue;
            }

            $cast_classname = $ReflectionAttribute->getArguments()[0];
            $attribute_classname = $ReflectionAttribute->getName();

            // One-to-many custom cast
            if ($Cache->remember($cast_classname . '::make',
                fn() => method_exists($cast_classname, 'make'))
            ) {
                $this->{$key} = (new $attribute_classname($cast_classname))->set((array)$value);
                continue;
            }

            // Built-in Casts
            switch ($attribute_classname) {
                case Cast::class:
                    $this->{$key} = (new $cast_classname)->set((array)$value);
                    break;
                case CastToArray::class:
                    $this->{$key} = array_map(fn($value) => $cast_classname::tryFrom($value), $value);
                    break;
                case CastToClasses::class:
                    $this->{$key} = (new $attribute_classname($cast_classname))->set((array)$value);
                    break;
            }
        }
    }

    public static function make($items = null): self
    {
        return new self($items);
    }
}