<?php

namespace App\Dto\NewsUpdate;

class NewsUpdateRequest
{
    public function __construct(public string $id, public string $title,public \DateTimeImmutable $date)
    {
    }
}