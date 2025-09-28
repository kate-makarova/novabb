<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $pluginDir = dirname(__DIR__) . '/../src/Plugins';

    if (!is_dir($pluginDir)) {
        return;
    }

    $pluginFolders = array_filter(glob($pluginDir . '/*'), 'is_dir');

    foreach ($pluginFolders as $folder) {
        $pluginName = basename($folder);
        $controllerPath = $folder . '/Controller';

        if (is_dir($controllerPath)) {
            $routes->import($controllerPath, 'attribute');
        }
    }
};
