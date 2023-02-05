<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Http\Symfony;

use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\HttpClientInterface;
use Saul\PhpExtension\Http\HttpMethod;

final class SymfonyHttpClient implements HttpClientInterface
{
    public function __construct(
        private ClientInterface $httpClient
    ) {
    }

    /**
     * @param array<string, string> $headers
     */
    public function get(string $url, array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            new Request(HttpMethod::GET->name, $url, $headers)
        );
    }

    /**
     * @param array<string, string> $headers
     */
    public function post(string $url, string $body = null, array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest(
            new Request(HttpMethod::POST->name, $url, $headers, $body)
        );
    }
}
