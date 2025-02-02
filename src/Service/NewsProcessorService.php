<?php

namespace App\Service;

use App\Interface\NewsProcessorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsProcessorService
{
    /**
     * @var NewsProcessorInterface[]
     */
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    public function handleRequest(Request $request): Response
    {
        foreach ($this->handlers as $handler) {
            if ($handler->isSupport($request)) {
                return $handler->process($request);
            }
        }
    }
}