<?php

namespace App\Consumer;

use App\Message\CreateNewsMessage;
use App\Repository\NewsRepository;
use App\Service\NewsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateNewsConsumer
{
    public function __construct(
        private readonly NewsService $newsService,
        private readonly NewsRepository $newsRepository
    ) {
    }

    public function __invoke(CreateNewsMessage $message): void
    {
        if ($this->newsRepository->findNewsForTitleAndDate($message->title, $message->date)) {
            //или логируем
            return;
        }

        $this->newsService->create(
            channelUrl: $message->channelUrl,
            title: $message->title,
            category: $message->category,
            date: $message->date
        );
    }
}