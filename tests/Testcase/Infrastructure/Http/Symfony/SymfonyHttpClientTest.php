<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\Http\Symfony;

use Saul\Core\Port\Http\HttpClientInterface;
use Saul\Infrastructure\Http\Symfony\SymfonyHttpClient;
use Saul\PhpExtension\Http\HttpResponseStatus;
use Saul\Test\Framework\AbstractSaulTestcase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @micro
 *
 * @small
 */
final class SymfonyHttpClientTest extends AbstractSaulTestcase
{
    private MockHttpClient $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = new MockHttpClient();
    }

    /**
     * @test
     */
    public function it_implements_the_http_client_interface(): void
    {
        self::assertInstanceOf(HttpClientInterface::class, $this->getClient());
    }

    /**
     * @test
     */
    public function it_can_send_a_get_request(): void
    {
        $client = $this->getClient();
        $responseBody = 'OK response';
        $this->setResponseBody($responseBody);

        $response = $client->get('https://test-url.com/');

        self::assertSame(HttpResponseStatus::OK, $response->getStatusCode());
        self::assertSame($responseBody, $response->getBody()->getContents());
        self::assertSame(1, $this->mockClient->getRequestsCount());
    }

    /**
     * @test
     */
    public function it_can_send_a_post_request(): void
    {
        $client = $this->getClient();

        $response = $client->post('https://some-url.com/');

        self::assertSame(HttpResponseStatus::OK, $response->getStatusCode());
        self::assertSame(1, $this->mockClient->getRequestsCount());
    }

    private function getClient(): HttpClientInterface
    {
        return new SymfonyHttpClient(
            new Psr18Client(
                $this->mockClient
            )
        );
    }

    private function setResponseBody(string $body): void
    {
        $this->mockClient->setResponseFactory(
            new MockResponse($body)
        );
    }
}
