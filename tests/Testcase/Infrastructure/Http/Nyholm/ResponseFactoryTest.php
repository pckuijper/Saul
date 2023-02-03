<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\Http\Nyholm;

use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\ResponseFactoryInterface;
use Saul\Infrastructure\Http\Nyholm\NyholmResponseFactory;
use Saul\PhpExtension\Http\HttpResponseStatus;
use Saul\Test\Framework\AbstractSaulTestcase;

/**
 * @micro
 *
 * @small
 */
final class ResponseFactoryTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_adheres_to_http_factory_interface(): void
    {
        self::assertInstanceOf(ResponseFactoryInterface::class, new NyholmResponseFactory());
    }

    /**
     * @test
     */
    public function it_can_create_psr_response(): void
    {
        $factory = new NyholmResponseFactory();

        $response = $factory->create('Test', HttpResponseStatus::OK);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('Test', $response->getBody()->getContents());
        self::assertSame(HttpResponseStatus::OK, $response->getStatusCode());
    }
}
