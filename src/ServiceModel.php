<?php /** @noinspection PhpUndefinedFunctionInspection */

namespace Zerotoprod\ServiceModel;

use ReflectionClass;
use Zerotoprod\ServiceModel\Attributes\CastUsing;
use Zerotoprod\ServiceModel\Attributes\MapFrom;
use Zerotoprod\ServiceModel\Attributes\ToArray;
use Zerotoprod\ServiceModel\Exceptions\ValidationException;

trait ServiceModel
{
    public static function make($items = null): self
    {
        if (is_string($items)) {
            $decoded = json_decode($items, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        }

        $self = new self;
        $ReflectionClass = new ReflectionClass(new self);
        $using_strict = in_array(Strict::class, $ReflectionClass->getTraitNames(), true);

        if (!$items || !(is_array($items) || is_object($items))) {
            if ($using_strict) {
                $self->validate();
            }

            return $self;
        }

        foreach ($items as $key => $value) {
            $Properties = $ReflectionClass->getProperties();
            $classnames = function () use ($Properties) {
                $classnames = [];
                foreach ($Properties as $Property) {
                    $attributes = $Property->getAttributes();
                    if (empty($attributes)) {
                        continue;
                    }
                    $classnames[] = $attributes[0]->getName();
                }

                return $classnames;
            };

            if (in_array(MapFrom::class, $classnames(), true)) {
                foreach ($Properties as $Property) {
                    $attributes = $Property->getAttributes();

                    if (empty($attributes)) {
                        continue;
                    }

                    $classname = $attributes[0]->getName();
                    if ($classname === MapFrom::class) {
                        $map = $attributes[0]->getArguments()[0];
                        if ($key === $map || (strpos($map, '.') && is_array($value) && $key)) {
                            $property_value = (new $classname($map))->parse((array)$value);
                            if ($property_value) {
                                $self->{$Property->getName()} = $property_value;
                                continue 2;
                            }
                        }
                    }
                }
            }

            if (!$ReflectionClass->hasProperty($key)) {
                continue;
            }


            $ReflectionProperty = $ReflectionClass->getProperty($key);
            $model_classname = $ReflectionProperty->getType()?->getName() ?? 'string';
            $ReflectionAttribute = $ReflectionProperty->getAttributes()[0] ?? null;

            if (!$ReflectionAttribute) {
                // Objects
                if (is_object($value) && $model_classname === get_class($value) && class_exists(get_class($value))) {
                    $self->{$key} = $value;
                    continue;
                }

                // ServiceModels
                if (method_exists($model_classname, 'make')) {
                    $self->{$key} = $model_classname::make($value);
                    continue;
                }

                // Enums
                if (isset($value->value)) {
                    $self->{$key} = $model_classname::tryFrom($value->value);
                    continue;
                }

                // Enum values
                if (enum_exists($model_classname)) {
                    $self->{$key} = $model_classname::tryFrom($value);
                    continue;
                }

                // Classes
                if (class_exists($model_classname)) {
                    if (is_a($value, $model_classname)) {
                        $self->{$key} = $value;
                        continue;
                    }

                    if (is_a($value, 'Illuminate\Support\Collection')) {
                        $self->{$key} = $value;
                        continue;
                    }

                    $self->{$key} = is_array($value)
                        ? new $model_classname(...$value)
                        : new $model_classname($value);
                    continue;
                }

                $self->{$key} = $value;

                continue;
            }

            $attribute_argument_0 = $ReflectionAttribute->getArguments()[0];
            $attribute_classname = $ReflectionAttribute->getName();

            // Cast to array
            if ((is_object($attribute_argument_0) || is_string($attribute_argument_0))
                && method_exists($attribute_argument_0, 'make')) {
                $trait_names = (new ReflectionClass($attribute_argument_0))->getTraitNames();
                if (in_array(ServiceModel::class, $trait_names, true)) {
                    $self->{$key} = (new $attribute_classname($attribute_argument_0))->parse((array)$value);
                    continue;
                }
            }

            $self->{$key} = match ($attribute_classname) {
                CastUsing::class => is_array($value)
                    ? $model_classname::$attribute_argument_0(...$value)
                    : $model_classname::$attribute_argument_0($value),
                default => count($ReflectionAttribute->getArguments()) > 1
                    ? (new $attribute_classname(...$ReflectionAttribute->getArguments()))->parse((array)$value)
                    : (new $attribute_classname($attribute_argument_0))->parse((array)$value),
            };
        }

        $self->afterMake($items);

        if ($using_strict) {
            $self->validate();
        }

        return $self;
    }

    public function afterMake($items): void
    {
    }

    /** @noinspection PhpUndefinedMethodInspection */
    public function toResource(): array
    {
        $ReflectionClass = new ReflectionClass($this);

        if (!$ReflectionClass->getAttributes()[0]) {
            return (new ToArray)->parse((array)$this);
        }

        $classname = $ReflectionClass->getAttributes()[0]->getArguments()[0];

        return (new $classname)->parse((array)$this);
    }

    public function validate(): self
    {
        $ReflectionClass = new ReflectionClass($this);

        foreach ($ReflectionClass->getProperties() as $Property) {
            if (!$Property->getType()->allowsNull()) {
                $name = $Property->getName();
                if (!isset($this->{$name})) {
                    throw new ValidationException("Property $name is not set");
                }
            }
        }

        return $this;
    }
}