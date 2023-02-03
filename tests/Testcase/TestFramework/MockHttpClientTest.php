<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\TestFramework;

use Saul\Core\Port\Http\HttpClientInterface;
use Saul\Core\Port\Http\ResponseFactoryInterface;
use Saul\Infrastructure\Http\Nyholm\NyholmResponseFactory;
use Saul\PhpExtension\Http\HttpMethod;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\MockHttpClient;

/**
 * @micro
 *
 * @small
 */
final class MockHttpClientTest extends AbstractSaulTestcase
{
    private ResponseFactoryInterface $responseFactory;

    protected function setUp(): void
    {
        $this->responseFactory = new NyholmResponseFactory();
    }

    /**
     * @test
     */
    public function it_implements_the_http_client_interface(): void
    {
        self::assertInstanceOf(HttpClientInterface::class, new MockHttpClient());
    }

    /**
     * @test
     */
    public function it_can_send_mock_http_get_requests(): void
    {
        $mockClient = new MockHttpClient();
        $mockClient->setupNextResponse($this->responseFactory->create(
            $expectedBody = 'Some content'
        ));

        $response = $mockClient->get('http://test-url.com');

        $lastRequest = $mockClient->getLastRequest();

        self::assertSame(HttpMethod::GET->name, $lastRequest->getMethod());
        self::assertSame($expectedBody, $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function it_can_send_mock_http_post_requests(): void
    {
        $mockClient = new MockHttpClient();
        $mockClient->setupNextResponse($this->responseFactory->create(
            $expectedBody = 'Some content'
        ));

        $response = $mockClient->post('http://test-url.com');

        $lastRequest = $mockClient->getLastRequest();

        self::assertSame(HttpMethod::POST->name, $lastRequest->getMethod());
        self::assertSame($expectedBody, $response->getBody()->getContents());
    }
}
