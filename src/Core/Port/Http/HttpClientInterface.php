<?php

declare(strict_types=1);

namespace Saul\Core\Port\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param array<string, string> $headers
     */
    public function get(string $url, array $headers = []): ResponseInterface;

    /**
     * @param array<string, string> $headers
     */
    public function post(string $url, array $headers = []): ResponseInterface;
}
