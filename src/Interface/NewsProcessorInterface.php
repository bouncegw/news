<?php

namespace App\Interface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface NewsProcessorInterface
{
    public function isSupport(Request $request): bool;

    public function process(Request $request): Response;
}