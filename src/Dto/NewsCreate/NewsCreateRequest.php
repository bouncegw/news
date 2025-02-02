<?php

namespace App\Dto\NewsCreate;

class NewsCreateRequest
{
    public function __construct(
        public string $channelUrl,
        public string $title,
        public string $category,
        public \DateTimeImmutable $date
    ) {
    }
}