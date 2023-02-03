<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\TestFramework\Spy;

use Nyholm\Psr7\Request;
use Saul\PhpExtension\Http\HttpMethod;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\Spy\SpyHttpClient;

/**
 * @small
 *
 * @micro
 */
final class SpyHttpClientTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_can_get_last_request_send(): void
    {
        $spy = new SpyHttpClient();
        $expectedUrl = 'http://some-url.com/';

        $spy->sendRequest(
            new Request(HttpMethod::GET->name, $expectedUrl)
        );

        $request = $spy->getLastRequest();

        self::assertSame(HttpMethod::GET->name, $request->getMethod());
        self::assertSame($expectedUrl, (string) $request->getUri());
    }
}
