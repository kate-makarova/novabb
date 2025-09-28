<?php

namespace App\Plugins\NovaBasicNews\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Plugins\NovaBasicNews\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/api/plugins/nova-basic-news/list', name: 'plugins_nova_basic_news_list')]
    public function list(EntityManagerInterface $entityManager) {
        $news = $entityManager->getRepository(News::class)->findAll();
        $response_data = [];
        foreach ($news as $newsItem) {
            $response_data[] = [
                'id' => $newsItem->getId(),
                'name' => $newsItem->getName(),
                'content' => $newsItem->getContent(),
            ];
        }
        return new JsonResponse($response_data);
    }
}