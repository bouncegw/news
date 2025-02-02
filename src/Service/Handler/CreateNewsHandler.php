<?php

namespace App\Service\Handler;

use App\Dto\NewsCreate\NewsCreateRequest;
use App\Dto\NewsCreate\NewsCreateResponse;
use App\Interface\NewsProcessorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CreateNewsHandler extends AbstractNewsHandler implements NewsProcessorInterface
{
    public function isSupport(Request $request): bool
    {
        return Request::METHOD_POST === $request->getMethod();
    }

    public function process(Request $request): Response
    {
        try {
            $content = $request->getContent();
            $newsDto =  $this->serializer->deserialize($content, NewsCreateRequest::class, JsonEncoder::FORMAT);
            $news = $this->newsService->create($newsDto);

            return new JsonResponse(new NewsCreateResponse($news->getId()), 201);
        }catch (\Exception $exception){
            //Обрабатываем ошибку
        }
    }
}