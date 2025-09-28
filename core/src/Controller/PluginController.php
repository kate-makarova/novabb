<?php

namespace App\Controller;

use App\Entity\Plugin;
use App\Entity\PluginWidget;
use Doctrine\Common\Collections\ArrayCollection;
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
            $response_data[] = $plugin->getPluginConfig();
        }
        return new JsonResponse($response_data);
//        return new JsonResponse([[
//            'remoteName' => 'helloPlugin',
//            'exposedModule' => './HelloComponent',
//            'remoteEntry' => '/plugins/helloPlugin/remoteEntry.js'
//        ]]);
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
//        return new JsonResponse([
//        //    'helloPlugin' => '/plugins/helloPlugin/remoteEntry.js',
//        ]);
    }

}
