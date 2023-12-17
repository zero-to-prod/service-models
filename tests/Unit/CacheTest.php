<?php

use Zerotoprod\ServiceModel\Cache\Cache;

it('sets and returns new value', function () {
    $cache = Cache::getInstance();
    $value = $cache->remember('key', function () {
        return 'new_value';
    });

    $this->assertEquals('new_value', $value);
    $this->assertEquals('new_value', $cache->get('key'));
});
it('returns singleton instance', function () {
    $cache = Cache::getInstance();
    $this->assertSame($cache, Cache::getInstance());
});

it('sets and gets value correctly', function () {
    $cache = Cache::getInstance();
    $cache->set('key', 'value');
    $this->assertEquals('value', $cache->get('key'));
});

it('returns null for non existent key', function () {
    $cache = Cache::getInstance();
    $this->assertNull($cache->get('non_existent_key'));
});

it('returns existing value', function () {
    $cache = Cache::getInstance();
    $cache->set('key', 'value');
    $value = $cache->remember('key', function () {
        return 'new_value';
    });

    $this->assertEquals('value', $value);
});