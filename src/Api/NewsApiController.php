<?php

namespace App\Api;

use App\Service\NewsProcessorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/news/api', name: 'api:')]
class NewsApiController extends AbstractController
{
    #[Route('/process', name: 'process')]
    public function createNews(Request $request, NewsProcessorService $processorService): Response
    {
        return $processorService->handleRequest($request);
    }
}
