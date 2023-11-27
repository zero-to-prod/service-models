<?php

namespace Zerotoprod\ServiceModel;

trait HasFactory
{
    public static function factory(...$parameters): Factory
    {
        /** @var Factory $factory */
        $factory = static::$factory;

        return (new $factory)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }
}
