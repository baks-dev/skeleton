<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function(FrameworkConfig $config, ContainerConfigurator $configurator) {

    $config->mailer()->dsn('%env(MAILER_DSN)%');

    $configurator->parameters()->set('PROJECT_NAME', 'Baks Development');
    $configurator->parameters()->set('PROJECT_HOMEPAGE', '%env(HOST)%');
    $configurator->parameters()->set('PROJECT_MAIL', 'noreply@baks.dev');
    $configurator->parameters()->set('PROJECT_NO_REPLY', 'noreply@baks.dev');

    $configurator->parameters()->set('APP_ENV', '%env(APP_ENV)%');

};
