<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Doctrine\DBAL\Connections\PrimaryReadReplicaConnection;
use Symfony\Config\DoctrineConfig;

return static function(DoctrineConfig $doctrine) {

    $doctrine
        ->dbal()
        ->connection('default', ['url' => '%env(resolve:DATABASE_URL)%']);

    $doctrine
        ->dbal()
        ->defaultConnection('default')
        ->connection('default')
        ->profilingCollectBacktrace('%kernel.debug%')
        ->useSavepoints(true);

    $doctrine->orm()
        ->autoGenerateProxyClasses(true);

    $orm = $doctrine->orm()->entityManager('default');
    $orm
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware')
        ->autoMapping(true);


    return;


    /** Пример настройки репликации */

    $doctrine
        ->dbal()
        ->connection('default', ['url' => '%env(resolve:DATABASE_MASTER_URL)%'])
        ->driver('pdo_pgsql')
        ->wrapperClass(PrimaryReadReplicaConnection::class)
        ->replica('replica1', ['url' => '%env(resolve:DATABASE_REPLICA_URL)%']);

    $doctrine
        ->dbal()
        ->defaultConnection('default')
        ->connection('default')
        ->profilingCollectBacktrace('%kernel.debug%')
        ->useSavepoints(true);


    $doctrine->orm()
        ->autoGenerateProxyClasses(true);

    $orm = $doctrine->orm()->entityManager('default');

    $orm
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware')
        ->autoMapping(true);

    // Настройка Second-Level Cache (L2C)

    $doctrine->orm()
        ->entityManager('default')
        ->secondLevelCache()
        ->enabled(true)
        ->regionCacheDriver()
        ->type('pool')
        ->pool('doctrine.result_cache_pool');



};
