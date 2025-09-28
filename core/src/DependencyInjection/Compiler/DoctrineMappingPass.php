<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DoctrineMappingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('doctrine.orm.default_attribute_metadata_driver')) {
            return;
        }
        $attributeDriverDef = $container->getDefinition('doctrine.orm.default_attribute_metadata_driver');

        $pluginEntityDirs = glob($container->getParameter('kernel.project_dir') . '/src/Plugins/*/Entity', GLOB_ONLYDIR);

        if (!$container->hasDefinition('doctrine.orm.default_metadata_driver')) {
            return;
        }
        $driverChainDef = $container->getDefinition('doctrine.orm.default_metadata_driver');
        $attributeDriverRef = new Reference('doctrine.orm.default_attribute_metadata_driver');


        foreach ($pluginEntityDirs as $dir) {
            $pluginName = basename(dirname($dir));
            $namespace = 'App\\Plugins\\' . $pluginName . '\\Entity';
            $attributeDriverDef->addMethodCall('addPaths', [[$dir]]);
            $driverChainDef->addMethodCall('addDriver', [$attributeDriverRef, $namespace]);
        }
    }
}
