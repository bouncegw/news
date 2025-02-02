<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\NewsChannel;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository     $categoryRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $categoryName, NewsChannel $newsChannel): Category
    {
        $category = $this->categoryRepository->findOneBy(['name' => $categoryName]);

        if ($category) {
            return $category;
        }
        $category = new Category();
        $category->setName($categoryName);

        $category->addNewsChannel($newsChannel);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}