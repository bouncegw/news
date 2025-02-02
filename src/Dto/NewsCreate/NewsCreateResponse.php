<?php

namespace App\Dto\NewsCreate;

class NewsCreateResponse
{
    public function __construct(public int $newsId)
    {
    }
}