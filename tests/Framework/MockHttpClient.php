<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

use Exception;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\HttpClientInterface;
use Saul\Infrastructure\Http\Symfony\SymfonyHttpClient;
use Saul\Test\Framework\Spy\SpyHttpClient;
use Symfony\Component\HttpClient\MockHttpClient as SymfonyMockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpClient\Response\MockResponse;

final class MockHttpClient implements HttpClientInterface
{
    private SpyHttpClient $spyClient;

    private HttpClientInterface $httpClient;

    /** @var MockResponse[] */
    private array $responses = [];

    public function __construct()
    {
        $this->spyClient = $this->setUpSpyClient();
        $this->httpClient = $this->createClient();
    }

    public function get(string $url): ResponseInterface
    {
        return $this->httpClient->get($url);
    }

    public function post(string $url): ResponseInterface
    {
        return $this->httpClient->post($url);
    }

    public function setupNextResponse(ResponseInterface $response): void
    {
        $this->responses[] = $this->transformResponseToMockResponse($response);
    }

    public function getLastRequest(): RequestInterface
    {
        return $this->spyClient->getLastRequest();
    }

    private function setUpSpyClient(): SpyHttpClient
    {
        return new SpyHttpClient(
            new Psr18Client(
                new SymfonyMockHttpClient($this->getNextResponse())
            )
        );
    }

    private function createClient(): HttpClientInterface
    {
        return new SymfonyHttpClient(
            $this->spyClient
        );
    }

    private function getNextResponse(): callable
    {
        return function (): MockResponse {
            if (count($this->responses) === 0) {
                throw new Exception('No resposnes set, use addResponse() first');
            }

            return array_shift($this->responses);
        };
    }

    private function transformResponseToMockResponse(ResponseInterface $response): MockResponse
    {
        return new MockResponse(
            $response->getBody()->getContents(),
            [
                'http_code' => $response->getStatusCode(),
            ]
        );
    }
}
