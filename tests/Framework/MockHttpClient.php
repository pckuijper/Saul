<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

use Exception;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\HttpClientInterface;
use Saul\PhpExtension\Http\HttpMethod;
use Saul\Test\Framework\Spy\SpyHttpClient;
use Symfony\Component\HttpClient\MockHttpClient as SymfonyMockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpClient\Response\MockResponse;

final class MockHttpClient implements HttpClientInterface, ClientInterface
{
    private SpyHttpClient $spyClient;

    /** @var MockResponse[] */
    private array $responses = [];

    public function __construct()
    {
        $this->spyClient = $this->setUpSpyClient();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->spyClient->sendRequest($request);
    }

    /**
     * @param array<string, string> $headers
     */
    public function get(string $url, array $headers = []): ResponseInterface
    {
        return $this->sendRequest(
            new Request(HttpMethod::GET->name, $url, $headers)
        );
    }

    /**
     * @param array<string, string> $headers
     */
    public function post(string $url, array $headers = []): ResponseInterface
    {
        return $this->sendRequest(
            new Request(HttpMethod::POST->name, $url, $headers)
        );
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

    private function getNextResponse(): callable
    {
        return function (): MockResponse {
            if (count($this->responses) === 0) {
                throw new Exception('No resposnes set, use `setupNextResponse()` first');
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
