<?php

namespace Zerotoprod\ServiceModel;

trait HasFactory
{
    public static function factory(...$parameters): Factory
    {
        return self::getFactory()->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    public static function getFactory(): Factory
    {
        return (new static::$factory);
    }
}
