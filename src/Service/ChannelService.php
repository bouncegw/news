<?php

namespace App\Service;


use App\Entity\NewsChannel;
use App\Repository\NewsChannelRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChannelService
{
    public function __construct(
        private readonly NewsChannelRepository $channelRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $name): NewsChannel
    {
        $newsChannel = $this->channelRepository->findOneBy(['name' => $name]);
        if ($newsChannel) {
            return $newsChannel;
        }

        $newsChannel = new NewsChannel();
        $newsChannel->setName($name);

        $this->entityManager->persist($newsChannel);
        $this->entityManager->flush();

        return $newsChannel;
    }
}