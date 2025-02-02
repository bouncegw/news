<?php

namespace App\Service;

use App\Dto\NewsCancel\NewsCancelRequest;
use App\Dto\NewsCreate\NewsCreateRequest;
use App\Dto\NewsUpdate\NewsUpdateRequest;
use App\Entity\Category;
use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsService
{
    public function __construct(
        private readonly ChannelService         $channelService,
        private readonly CategoryService        $categoryService,
        private readonly NewsRepository $newsRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(NewsCreateRequest $newsDto): News
    {

        if ($news = $this->newsRepository->findNewsForTitleAndDate($newsDto->title, $newsDto->date)) {
            return $news;
        }
        $newsChannel = $this->channelService->create($newsDto->channelUrl);

        $category = $this->categoryService->create($newsDto->category,$newsChannel);


        $news = $this->createNews($category, $newsDto->title, $newsDto->date);

        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $news;
    }

    public function cancel(NewsCancelRequest $newsCancelRequest): void
    {
        try {
            $news = $this->newsRepository->findNewsForTitleAndDate($newsCancelRequest->title, $newsCancelRequest->date);

            $this->entityManager->remove($news);
            $this->entityManager->flush();
        }catch (\Exception $exception){
            //здесь можно обрабатывать ошику, если не нашли новость в бд
        }
    }

    public function update(NewsUpdateRequest $newsUpdateRequest): void
    {
        try {
            $news = $this->newsRepository->find($newsUpdateRequest->id);
            $news->setTitle($newsUpdateRequest->title);
            $news->setParsedAt($newsUpdateRequest->date);
            $this->entityManager->flush();
        }catch (\Exception $exception){
            //здесь можно обрабатывать ошику, если не нашли новость в бд
        }
    }

    private function createNews(Category $category, string $title, \DateTimeImmutable $date): News
    {
        $news = new News();
        $news->setCategory($category);
        $news->setTitle($title);
        $news->setCreatedAt(new \DateTimeImmutable());
        $news->setParsedAt($date);

        return $news;
    }
}