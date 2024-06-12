<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\DoctrineConfig;

return static function(DoctrineConfig $doctrine) {

    $doctrine
        ->dbal()
        ->connection('default', ['url' => '%env(resolve:DATABASE_URL)%'])
        ->profilingCollectBacktrace('%kernel.debug%')
        ->useSavepoints(true)
    ;

    $doctrine->orm()
        ->autoGenerateProxyClasses(true);

    $orm = $doctrine->orm()->entityManager('default');
    $orm
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware')
        ->autoMapping(true);


};
