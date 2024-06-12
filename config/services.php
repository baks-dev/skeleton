<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Core\Type\Locale\Locales\LocaleInterface;
use Doctrine\Common\Cache\CacheProvider;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return static function (ContainerConfigurator $configurator) {

    $configurator->parameters()->set('project_dir', '%kernel.project_dir%');

    /** Дамп сервисного контейнера в один файл */
    $configurator->parameters()->set('container.dumper.inline_factories', true);

    /** Отключить дамп контейнера как XML в режиме отладки */
    $configurator->parameters()->set('debug.container.dump', false);

};
