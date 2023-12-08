<?php

namespace Zerotoprod\ServiceModel;

use ReflectionClass;

trait ServiceModel
{
    public function __construct(mixed $items = null)
    {
        if (!$items) {
            return;
        }
        $reflection_cache = [];
        $model = [];
        $reflection_cache[static::class] = new ReflectionClass($this);
        $ReflectionClass = $reflection_cache[static::class];
        foreach ($items as $key => $value) {
            // Ignore non-existing properties
            if (!$ReflectionClass->hasProperty($key)) {
                continue;
            }
            // Caching
            $cache_key = static::class . '::' . $key;
            $reflection_cache[$cache_key] = $ReflectionClass->getProperty($key);
            $ReflectionProperty = $reflection_cache[$cache_key];
            $model[$cache_key] = $ReflectionProperty->getType()?->getName() ?? 'string';
            $model_classname = $model[$cache_key];
            $ReflectionAttribute = $ReflectionProperty->getAttributes()[0] ?? null;

            if (!$ReflectionAttribute) {
                // One-to-One Cast
                if (method_exists($model_classname, 'make')) {
                    $this->{$key} = $model_classname::make($value);
                    continue;
                }

                // Enums
                if (enum_exists($model_classname)) {
                    $this->{$key} = $model_classname::tryFrom($value);
                    continue;
                }

                // Native types
                $this->{$key} = $value;

                continue;
            }
            $cast_classname = $ReflectionAttribute->getArguments()[0];
            $attribute_classname = $ReflectionAttribute->getName();

            // One-to-many custom cast
            if (method_exists($cast_classname, 'make')) {
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
            }
        }
    }

    public static function make($items = null): self
    {
        return new self($items);
    }
}