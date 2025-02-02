<?php

namespace App\Service\Handler;

use App\Service\NewsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractNewsHandler
{
    public function __construct(
        protected readonly SerializerInterface $serializer,
        protected readonly NewsService $newsService
    ) {
    }

    abstract public function process(Request $request): Response;
}