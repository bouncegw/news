<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: NewsChannel::class, inversedBy: 'categories')]
    #[ORM\JoinTable(name: 'category_news_channel')]
    private Collection $newsChannels;

    #[ORM\OneToMany(targetEntity: News::class, mappedBy: 'category', cascade: ['persist', 'remove'])]
    private Collection $news;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->newsChannels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getNewsChannels(): Collection
    {
        return $this->newsChannels;
    }

    public function addNewsChannel(NewsChannel $newsChannel): self
    {
        if (!$this->newsChannels->contains($newsChannel)) {
            $this->newsChannels[] = $newsChannel;
            $newsChannel->getCategories()->add($this); // Добавляем только с одной стороны
        }
        return $this;
    }

    public function removeNewsChannel(NewsChannel $newsChannel): self
    {
        $this->newsChannels->removeElement($newsChannel); // Удаляем связь только здесь
        return $this;
    }

    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setCategory($this);
        }
        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->removeElement($news)) {
            if ($news->getCategory() === $this) {
                $news->setCategory(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
