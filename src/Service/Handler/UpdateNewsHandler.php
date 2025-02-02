<?php

namespace App\Service\Handler;

use App\Dto\NewsCancel\NewsCancelResponse;
use App\Dto\NewsUpdate\NewsUpdateRequest;
use App\Interface\NewsProcessorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class UpdateNewsHandler extends AbstractNewsHandler implements NewsProcessorInterface
{

    public function isSupport(Request $request): bool
    {
        return Request::METHOD_PATCH === $request->getMethod();
    }

    public function process(Request $request): Response
    {
        try {
            $content = $request->getContent();
            $newsDto =  $this->serializer->deserialize($content, NewsUpdateRequest::class, JsonEncoder::FORMAT);
            $this->newsService->update($newsDto);

            return new JsonResponse(new NewsCancelResponse('Новость успешно обновлена'), 201);
        }catch (\Exception $exception){
            //Обрабатываем ошибку
        }
    }
}