<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Cache\RegionsConfiguration;
use Doctrine\ORM\Configuration;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Config\DoctrineConfig;

return static function(DoctrineConfig $config) {

    $config
        ->dbal()
        ->connection('default', ['url' => '%env(resolve:DATABASE_URL)%']);


};

