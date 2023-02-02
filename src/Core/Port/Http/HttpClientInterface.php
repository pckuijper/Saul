<?php

declare(strict_types=1);

namespace Saul\Core\Port\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $url): ResponseInterface;

    public function post(string $url): ResponseInterface;
}
