<?php

namespace Zerotoprod\ServiceModel;

use ReflectionClass;

trait ServiceModel
{
    public function __construct(?array $items)
    {
        if ($items === null) {
            return;
        }

        static $ReflectionClass = null;
        static $property_cache = [];
        static $traitNames = null;
        static $enum_cache = [];

        if ($ReflectionClass === null) {
            $ReflectionClass = new ReflectionClass($this);
            $traitNames = $ReflectionClass->getTraitNames();
        }

        foreach ($items as $key => $item) {
            if (!$ReflectionClass->hasProperty($key)) {
                continue;
            }

            $reflection_property = $property_cache[$key] ?? $ReflectionClass->getProperty($key);
            $property_cache[$key] = $reflection_property;

            $property_type_name = $reflection_property->getType()?->getName() ?? 'string';
            $attributes = $reflection_property->getAttributes();

            if (!empty($attributes) && $attributes[0]->getName() === Cast::class) {
                $class = $attributes[0]->getArguments()[0];
                $this->{$key} = (new $class)->set($item);

                continue;
            }

            if (method_exists($property_type_name, 'make')
                && in_array(ServiceModel::class, $traitNames, true)
            ) {
                $this->{$key} = !empty($attributes[0])
                    ? (new ($attributes[0]->getName())($attributes[0]->getArguments()[0]))->set($item)
                    : $property_type_name::make($item);

                continue;
            }

            if ($attributes
                && $property_type_name === 'array'
                && method_exists($attributes[0]->getArguments()[0], 'make')
            ) {
                $this->{$key} = (new ($attributes[0]->getName())($attributes[0]->getArguments()[0]))->set($item);

                continue;
            }

            if(isset($attributes[0])
                && $attributes[0]->getName() === CastToArray::class
                && enum_exists($attributes[0]->getArguments()[0])
            ) {
                $enum = $attributes[0]->getArguments()[0];
                $this->{$key} = array_map(fn($value) => $enum::tryFrom($value), $item);

                continue;
            }

            $enum_exists = $enum_cache[$property_type_name] ?? enum_exists($property_type_name);
            $enum_cache[$property_type_name] = $enum_exists;

            $this->{$key} = $enum_exists && (is_int($item) || is_string($item))
                ? $property_type_name::tryFrom($item)
                : $item;
        }
    }


    /**
     * Create a new instance and set its attributes.
     */
    public static function make(?array $items = null): self
    {
        return new self($items);
    }
}
