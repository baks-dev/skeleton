<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config)
{
    $cache = $config->cache();


//    $cache
//        ->app('cache.adapter.redis')
//        ->defaultRedisProvider("redis://%env(REDIS_PASSWORD)%@%env(REDIS_HOST)%:%env(REDIS_PORT)%")
//    ;
//
//    $cache
//        ->app('cache.adapter.redis')
//        ->system('cache.adapter.redis')
//    ;


    $cache
        ->pool('cache.app')
        ->adapters(['cache.adapter.apcu'])
    ;

};
