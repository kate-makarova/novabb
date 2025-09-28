<?php

namespace App\Controller;

use App\Entity\Plugin;
use App\Entity\PluginWidget;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PluginController extends AbstractController
{
    #[Route('/api/plugins/enabled/{type}', name: 'plugins')]
    public function listEnabled(EntityManagerInterface $entityManager, string $type) {
        $widgetPlugins = $entityManager->getRepository(PluginWidget::class)->findBy(['widgetName' => $type]);
        $response_data = [];
        foreach ($widgetPlugins as $widgetPlugin) {
            $plugin = $widgetPlugin->getPlugin();
            $data = $plugin->getPluginConfig();
            $data->componentName = $widgetPlugin->getComponentName();
            $response_data[] = $data;
        }
        return new JsonResponse($response_data);
    }

    #[Route('/api/manifest', name: 'plugin_manifest')]
    public function manifest(EntityManagerInterface $entityManager) {
        $plugins = $entityManager->getRepository(Plugin::class)->findBy(['isEnabled' => true]);
        $response_data = [];
        foreach ($plugins as $plugin) {
            $config = $plugin->getPluginConfig();
            $response_data[$config->remoteName] = $config->remoteEntry;
        }
        return new JsonResponse($response_data);
    }

    #[Route('/api//install/{pluginName}', name: 'plugin_install')]
    public function install(EntityManagerInterface $entityManager) {

    }

}
