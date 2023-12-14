<?php

namespace Zerotoprod\ServiceModel;
class Cache
{
    private static ?Cache $instance = null;
    private array $cache = [];

    public static function getInstance(): Cache
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
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
        if (!isset($this->cache[$key])) {
            $this->cache[$key] = $callable();
        }

        return $this->cache[$key];
    }
}