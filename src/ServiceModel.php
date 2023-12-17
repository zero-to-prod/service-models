<?php /** @noinspection PhpUndefinedFunctionInspection */

namespace Zerotoprod\ServiceModel;

use ReflectionClass;
use Zerotoprod\ServiceModel\Attributes\Cast;
use Zerotoprod\ServiceModel\Attributes\CastMethod;
use Zerotoprod\ServiceModel\Attributes\CastToArray;
use Zerotoprod\ServiceModel\Attributes\CastToClasses;
use Zerotoprod\ServiceModel\Cache\Cache;

trait ServiceModel
{
    public static function make($items = null): self
    {
        $self = new self;

        if (!$items || !(is_array($items) || is_object($items))) {
            return $self;
        }

        $Cache = Cache::getInstance();
        $ReflectionClass = $Cache->remember(static::class, fn() => new ReflectionClass($self));

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

                // ServiceModels
                if ($Cache->remember($model_classname . '::make',
                    fn() => method_exists($model_classname, 'make'))
                ) {
                    $self->{$key} = $model_classname::make($value);
                    continue;
                }

                // Enums
                if (isset($value->value)) {
                    $self->{$key} = $model_classname::tryFrom($value->value);
                    continue;
                }

                // Enum values
                if ($Cache->remember($model_classname . '::enum',
                    fn() => enum_exists($model_classname))
                ) {
                    $self->{$key} = $model_classname::tryFrom($value);
                    continue;
                }

                // Classes
                if ($Cache->remember($model_classname . '::class',
                    fn() => class_exists($model_classname))
                ) {
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
            if ($Cache->remember($attribute_argument_0 . '::cast',
                fn() => method_exists($attribute_argument_0, 'make'))
            ) {
                $self->{$key} = (new $attribute_classname($attribute_argument_0))->parse((array)$value);
                continue;
            }

            switch ($attribute_classname) {
                case Cast::class:
                    $self->{$key} = (new $attribute_argument_0)->parse((array)$value);
                    break;
                case CastToArray::class:
                    $self->{$key} = array_map(
                        fn($value) => isset($value->value) ? $value : $attribute_argument_0::tryFrom($value),
                        $value
                    );
                    break;
                case CastToClasses::class:
                    $self->{$key} = (new $attribute_classname($attribute_argument_0))->parse((array)$value);
                    break;
                case CastMethod::class:
                    $self->{$key} = $model_classname::$attribute_argument_0($value);
            }
        }

        return $self;
    }
}