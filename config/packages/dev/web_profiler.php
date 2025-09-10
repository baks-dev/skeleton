<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;
use Symfony\Config\WebProfilerConfig;

return static function(WebProfilerConfig $config, FrameworkConfig $framework) {

    $config
        ->toolbar()
        ->ajaxReplace(true);

    $framework
        ->profiler()
        ->onlyExceptions(false)
        ->collectSerializerData(true);
};
