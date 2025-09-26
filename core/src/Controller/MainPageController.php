<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MainPageController extends AbstractController
{
    #[Route('/api/main', name: 'main_page')]
    public function mainPage(): JsonResponse
    {
        return new JsonResponse(['response' => 42]);
    }
}
