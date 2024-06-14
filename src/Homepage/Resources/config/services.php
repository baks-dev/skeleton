<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Core\Cache\RedisCache;
use App\Core\Lock\RedisLock;
use BaksDev\Core\Cache\AppCacheInterface;
use BaksDev\Core\Lock\AppLockInterface;

return static function (ContainerConfigurator $configurator): void {

    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $NAMESPACE = 'App\Core\\';

    $MODULE = substr(__DIR__, 0, strpos(__DIR__, "Resources"));

    $services
        ->load($NAMESPACE, $MODULE)
        ->exclude($MODULE.'{Entity,Resources,Type,*DTO.php,*Message.php}');

};
