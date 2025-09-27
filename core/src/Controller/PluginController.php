<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PluginController extends AbstractController
{
    #[Route('/api/plugins/enabled', name: 'plugins')]
    public function listEnabled() {
        return new JsonResponse([[
            'remoteName' => 'helloPlugin',
            'exposedModule' => './HelloComponent',
            'remoteEntry' => '/plugins/helloPlugin/remoteEntry.js'
        ]]);
    }

    #[Route('/api/manifest', name: 'plugin_manifest')]
    public function manifest() {
        return new JsonResponse([
            'helloPlugin' => '/plugins/helloPlugin/remoteEntry.js',
        ]);
    }

}
