<?php

namespace Zerotoprod\ServiceModel\Cache;
class Cache
{
    private static ?Cache $instance = null;
    private array $cache = [];

    public static function getInstance(): Cache
    {
        return self::$instance ?? (self::$instance = new self);
    }

    public function set(string $key, mixed $value): void
    {
        $this->cache[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->cache[$key] ?? null;
    }

    public function remember(string $key, callable $callable)
    {
        return $this->cache[$key] ?? ($this->cache[$key] = $callable());
    }
}