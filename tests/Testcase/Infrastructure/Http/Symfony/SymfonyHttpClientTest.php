<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\Http\Symfony;

use Saul\Core\Port\Http\HttpClientInterface;
use Saul\Infrastructure\Http\Nyholm\NyholmResponseFactory;
use Saul\Infrastructure\Http\Symfony\SymfonyHttpClient;
use Saul\PhpExtension\Http\ContentTypeHttpHeader;
use Saul\PhpExtension\Http\HttpMethod;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\MockHttpClient;

/**
 * @micro
 *
 * @small
 */
final class SymfonyHttpClientTest extends AbstractSaulTestcase
{
    private MockHttpClient $mockClient;
    private NyholmResponseFactory $responseFactory;

    protected function setUp(): void
    {
        $this->mockClient = new MockHttpClient();
        $this->responseFactory = new NyholmResponseFactory();
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
        $this->mockClient->setupNextResponse($this->responseFactory->create());

        $client->get('test-url');

        $lastRequest = $this->mockClient->getLastRequest();
        self::assertSame(HttpMethod::GET->name, $lastRequest->getMethod());
    }

    /**
     * @test
     */
    public function it_can_specify_headers_on_get_requests(): void
    {
        $client = $this->getClient();
        $this->mockClient->setupNextResponse($this->responseFactory->create());

        $client->get(
            'https://test-url.com/',
            [
                ContentTypeHttpHeader::NAME => ContentTypeHttpHeader::VALUE_APPLICATION_JSON,
            ]
        );

        $lastRequest = $this->mockClient->getLastRequest();
        $contentTypeHeader = $lastRequest->getHeader(ContentTypeHttpHeader::NAME);

        self::assertContains(ContentTypeHttpHeader::VALUE_APPLICATION_JSON, $contentTypeHeader);
    }

    /**
     * @test
     */
    public function it_can_send_a_post_request(): void
    {
        $client = $this->getClient();
        $this->mockClient->setupNextResponse($this->responseFactory->create());

        $client->post('https://some-url.com/');

        $lastRequest = $this->mockClient->getLastRequest();
        self::assertSame(HttpMethod::POST->name, $lastRequest->getMethod());
    }

    /**
     * @test
     */
    public function it_can_specify_headers_on_post_request(): void
    {
        $client = $this->getClient();
        $this->mockClient->setupNextResponse($this->responseFactory->create());

        $client->post(
            'https://test-url.com/',
            null,
            [
                ContentTypeHttpHeader::NAME => ContentTypeHttpHeader::VALUE_APPLICATION_JSON,
            ]
        );

        $lastRequest = $this->mockClient->getLastRequest();
        $contentTypeHeader = $lastRequest->getHeader(ContentTypeHttpHeader::NAME);

        self::assertContains(ContentTypeHttpHeader::VALUE_APPLICATION_JSON, $contentTypeHeader);
    }

    /**
     * @test
     */
    public function it_can_set_the_body_of_a_post_request(): void
    {
        $client = $this->getClient();
        $this->mockClient->setupNextResponse($this->responseFactory->create());
        $expectedBody = 'SOME BODY';

        $client->post(
            'https://test-url.com/',
            $expectedBody
        );

        $lastRequest = $this->mockClient->getLastRequest();

        self::assertSame($expectedBody, $lastRequest->getBody()->getContents());
    }

    private function getClient(): HttpClientInterface
    {
        return new SymfonyHttpClient(
            $this->mockClient
        );
    }
}
