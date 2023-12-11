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

        if (!$Cache->get(static::class)) {
            $Cache->set(static::class, new ReflectionClass($this));
        }

        $ReflectionClass = $Cache->get(static::class);

        foreach ($items as $key => $value) {
            if (!$ReflectionClass->hasProperty($key)) {
                continue;
            }

            $cache_key = static::class . '::' . $key;

            if (!$Cache->get($cache_key)) {
                $Cache->set($cache_key, $ReflectionClass->getProperty($key));
            }

            $ReflectionProperty = $Cache->get($cache_key);

            if (!$Cache->get($cache_key . '::type')) {
                $Cache->set($cache_key . '::type', $ReflectionProperty->getType()?->getName() ?? 'string');
            }

            $model_classname = $Cache->get($cache_key . '::type');
            $ReflectionAttribute = $ReflectionProperty->getAttributes()[0] ?? null;


            if (!$ReflectionAttribute) {
                // One-to-One Cast
                if (method_exists($model_classname, 'make')) {
                    $this->{$key} = $model_classname::make($value);
                    continue;
                }

                // Enums: value checking to pass enum directly.
                if ((is_int($value) || is_string($value)) && enum_exists($model_classname)) {
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