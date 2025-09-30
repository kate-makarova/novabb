<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Subforum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MainPageController extends AbstractController
{
    #[Route('/api/main', name: 'main_page')]
    public function mainPage(EntityManagerInterface $entityManager): JsonResponse
    {
        $categories = $entityManager->getRepository(Category::class)->findBy([], ['position' => 'ASC']);

        $response_data = [];
        foreach ($categories as $category) {
            $category_response_data = [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'subforums' => []
            ];

            /** @var Subforum $subforum */
            foreach ($category->getSubforums() as $subforum) {
                $category_response_data['subforums'][] = [
                    'id' => $subforum->getId(),
                    'title' => $subforum->getTitle()
                ];
            }
            $response_data[] = $category_response_data;
        }

        return new JsonResponse($response_data);
    }

    #[Route('/api/test', name: 'test_page')]
    public function testPage(): JsonResponse {
        return new JsonResponse(['test' => true]);
    }

}
