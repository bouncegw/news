<?php

namespace App\Message;

class CreateNewsMessage
{
    public function __construct(
        public string $channelUrl,
        public string $title,
        public string $category,
        public \DateTimeImmutable $date
    ) {
    }
}