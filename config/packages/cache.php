<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function(FrameworkConfig $config) {

    /** Конфигурация кеширования в Redis */

    /*
        Очистить временные файлы старше 1 дня
        find /tmp -ctime +1 -exec rm -rf {} +
    */

    $config->cache()
        ->app('cache.adapter.redis')
        ->defaultRedisProvider("redis://%env(REDIS_PASSWORD)%@%env(REDIS_HOST)%:%env(REDIS_PORT)%")
        ->system('cache.adapter.redis');

    $config->cache()
        ->pool('doctrine.result_cache_pool')
        ->adapters(['cache.adapter.redis']) // Или filesystem/apcu
        ->defaultLifetime(3600); // 1 час


};
