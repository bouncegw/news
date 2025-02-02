<?php

namespace App\Service;

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

    public function create(string $channelUrl, string $title, string $category, \DateTimeImmutable $date): News
    {

        if ($news = $this->newsRepository->findNewsForTitleAndDate($title, $date)) {
            return $news;
        }
        $newsChannel = $this->channelService->createChannel($channelUrl);

        $category = $this->categoryService->create($category,$newsChannel);


        $news = $this->createNews($category, $title, $date);

        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $news;
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