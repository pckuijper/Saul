<?php

declare(strict_types=1);

namespace Saul\Test\Framework\Spy;

use Exception;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;

final class SpyHttpClient implements ClientInterface
{
    private ClientInterface $httpClient;
    private ?RequestInterface $lastRequest;

    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? $this->getMockClient();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastRequest = $request;

        return $this->httpClient->sendRequest($request);
    }

    public function getLastRequest(): RequestInterface
    {
        if ($this->lastRequest === null) {
            throw new Exception('No request has been made yet');
        }

        $body = $this->lastRequest->getBody();
        $body->rewind();

        return $this->lastRequest;
    }

    private function getMockClient(): ClientInterface
    {
        return new Psr18Client(
            new MockHttpClient()
        );
    }
}
