<?php

namespace App\Service\Handler;

use App\Dto\NewsCancel\NewsCancelRequest;
use App\Dto\NewsCancel\NewsCancelResponse;
use App\Interface\NewsProcessorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CancelNewsHandler extends AbstractNewsHandler implements NewsProcessorInterface
{
    public function isSupport(Request $request): bool
    {
        return Request::METHOD_DELETE === $request->getMethod();
    }

    public function process(Request $request): Response
    {
        try {
            $content = $request->getContent();
            $newsDto =  $this->serializer->deserialize($content, NewsCancelRequest::class, JsonEncoder::FORMAT);
            $this->newsService->cancel($newsDto);

            return new JsonResponse(new NewsCancelResponse('Новость успешно удалена'), 201);
        }catch (\Exception $exception){
            //Обрабатываем ошибку
        }
    }
}