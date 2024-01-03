<?php

use Zerotoprod\ServiceModel\Attributes\Describe;
use Zerotoprod\ServiceModel\Attributes\MapFrom;

if (!function_exists('ztp_get_Describe')) {
    function ztp_get_Describe(array $Attributes): ?Describe
    {
        $Describe = null;
        foreach ($Attributes as $ReflectionAttribute) {
            if ($ReflectionAttribute->getName() === Describe::class) {
                $Describe = new Describe(...$ReflectionAttribute->getArguments());
            }
        }
        return $Describe;
    }
}
if (!function_exists('ztp_merge_Describe')) {
    function ztp_merge_Describe(?Describe $instance1, ?Describe $instance2): Describe
    {
        if ($instance1 === null && $instance2 === null) {
            return new Describe;
        }
        if ($instance1 === null) {
            return $instance2;
        }

        return new Describe(array_merge((array)$instance1, (array)$instance2));
    }
}

if (!function_exists('ztp_map_from')) {
    function ztp_map_from(Describe $Describe, array $items): mixed
    {
        $key = explode('.', $Describe->map_from);
        if (is_array($key) && strpos($Describe->map_from, '.')) {
            return (new MapFrom($Describe->map_from))->parse($items[$key[0]]);
        }

        return null;
    }
}
