<?php

namespace App\Dto\NewsCancel;

class NewsCancelRequest
{
    public function __construct(public string $title, public \DateTimeImmutable $date)
    {
    }
}