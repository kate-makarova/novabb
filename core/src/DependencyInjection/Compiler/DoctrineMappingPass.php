<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DoctrineMappingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('doctrine.orm.default_metadata_driver')) {
            return;
        }

        $driverChainDef = $container->getDefinition('doctrine.orm.default_metadata_driver');

        // Create one AttributeDriver for plugin entities
        $attributeDriverRef = new Reference('doctrine.orm.default_attribute_metadata_driver');

        $pluginDirs = glob($container->getParameter('kernel.project_dir').'/src/Plugins/*/Entity', GLOB_ONLYDIR);

        foreach ($pluginDirs as $dir) {
            $namespace = 'App\\Plugins\\' . basename(dirname($dir)) . '\\Entity';
            $driverChainDef->addMethodCall('addDriver', [$attributeDriverRef, $namespace]);
        }
    }
}

