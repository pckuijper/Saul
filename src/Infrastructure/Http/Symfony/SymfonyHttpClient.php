<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Http\Symfony;

use Nyholm\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\HttpClientInterface;
use Symfony\Component\HttpClient\Psr18Client;

final class SymfonyHttpClient implements HttpClientInterface
{
    private const HTTP_GET = 'GET';
    private const HTTP_POST = 'POST';

    public function __construct(
        private Psr18Client $httpClient
    ) {
    }

    public function get(string $url): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            new Request(self::HTTP_GET, $url)
        );
    }

    public function post(string $url): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            new Request(self::HTTP_POST, $url)
        );
    }
}
