<?php

/**
 * @noinspection PhpUndefinedMethodInspection
 * @noinspection PhpUndefinedFunctionInspection
 */

namespace Zerotoprod\ServiceModel;

use ReflectionClass;
use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\Attributes\ToArray;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

trait ServiceModel
{
    public static function from($items = null): self
    {
        if (is_string($items)) {
            $decoded = json_decode($items, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        }
        $self = new self;
        $ReflectionClass = new ReflectionClass($self);
        $DescribeModel = ztp_get_Describe($ReflectionClass->getAttributes());
        $items = (array)$items;

        foreach ($ReflectionClass->getProperties() as $ReflectionProperty) {
            $Describe = ztp_merge_Describe($DescribeModel, ztp_get_Describe($ReflectionProperty->getAttributes()));
            $property_name = $ReflectionProperty->getName();
            if (isset($items[$property_name])) {
                $model_classname = $ReflectionProperty->getType()?->getName() ?? 'string';
                if (class_exists($Describe->from) || class_exists($model_classname)) {
                    if ($model_classname === 'array') {
                        $values = [];
                        foreach ($items[$property_name] as $item) {
                            if (isset($item->value) || method_exists($Describe->from, 'from')) {
                                $values[] = isset($item->value)
                                    ? $item // enum
                                    : $Describe->from::from($item);
                                continue;
                            }
                            $values[] = is_array($item)
                                ? new $Describe->from(...$item)
                                : new $Describe->from($item);
                        }
                        $self->{$property_name} = $values;
                        continue;
                    }

                    if ($Describe->from && method_exists($Describe->from, 'parse')) {
                        $self->{$property_name} = (new $Describe->from)->parse($items[$property_name]);
                        continue;
                    }

                    if (!is_object($items[$property_name])) {
                        if ($Describe->via) {
                            $self->{$property_name} = is_array($items[$property_name])
                                ? $model_classname::{$Describe->via}(...$items[$property_name])
                                : $model_classname::{$Describe->via}($items[$property_name]);
                            continue;
                        }
                        if (enum_exists($model_classname)) {
                            $self->{$property_name} = $model_classname::from($items[$property_name]);
                            continue;
                        }
                        if (method_exists($model_classname, 'from')) {
                            $self->{$property_name} = $model_classname::from($items[$property_name]);
                            continue;
                        }
                        $self->{$property_name} = is_array($items[$property_name])
                            ? new $model_classname(...$items[$property_name])
                            : new $model_classname($items[$property_name]);
                        continue;
                    }
                    $self->{$property_name} = $items[$property_name];
                    continue;
                }

                if ($ReflectionProperty->getAttributes()) {
                    foreach ($ReflectionProperty->getAttributes() as $ReflectionAttribute) {
                        if ($Describe->map_from) {
                            $property_value = ztp_map_from($Describe, $items);
                            if ($property_value) {
                                $self->{$property_name} = $property_value;
                                continue;
                            }
                            $self->{$property_name} = $items[$Describe->map_from];
                            continue;
                        }

                        $classname = $ReflectionAttribute->getName();
                        if (method_exists($classname, 'parse')) {
                            $self->{$property_name} = count($ReflectionAttribute->getArguments()) > 1
                                ? (new $classname(...$ReflectionAttribute->getArguments()))->parse($items[$property_name])
                                : (new $classname($ReflectionAttribute->getArguments()[0]))->parse($items[$property_name]);
                            continue;
                        }
                        $self->{$property_name} = $items[$property_name];
                    }
                    continue;
                }
                $self->{$property_name} = $items[$property_name];
            }

            $attributes = $ReflectionProperty->getAttributes();

            if (empty($attributes)) {
                continue;
            }

            if ($Describe->map_from) {
                $property_value = ztp_map_from($Describe, $items);
                if ($property_value) {
                    $self->{$property_name} = $property_value;
                    continue;
                }
                $self->{$property_name} = $items[$Describe->map_from];
            }
        }
        $Describe = ztp_get_Describe($ReflectionClass->getAttributes()) ?? new Describe;
        if ($Describe->require_typed_properties || $Describe->strict) {
            $self->validate();
        }
        $self->afterMake($items);

        return $self;
    }

    public function afterMake($items): void
    {
    }

    /** @noinspection PhpUndefinedMethodInspection */
    public function toResource(): array
    {
        $ReflectionClass = new ReflectionClass($this);
        $Describe = ztp_get_Describe($ReflectionClass->getAttributes()) ?? new Describe;
        if ($Describe->output_as) {
            $classname = $Describe->output_as;
            return (new $classname)->parse((array)$this);
        }

        return (new ToArray)->parse((array)$this);
    }

    public function validate(): self
    {
        $ReflectionClass = new ReflectionClass($this);
        $DescribeModel = ztp_get_Describe($ReflectionClass->getAttributes());
        foreach ($ReflectionClass->getProperties() as $Property) {
            $Describe = ztp_merge_Describe($DescribeModel, ztp_get_Describe($Property->getAttributes()));
            if ($Describe->strict && !isset($this->{$Property->getName()}) && !$Property->getType()->allowsNull()) {
                throw new ValidationException("Property {$Property->getName()} is not set");
            }
            if ($Describe->require_typed_properties && $Property->getType() === null) {
                throw new ValidationException("Property {$Property->getName()} must have a type.");
            }
        }
        return $this;
    }
}