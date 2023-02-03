<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Http\Nyholm;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Saul\Core\Port\Http\ResponseFactoryInterface;
use Saul\PhpExtension\Http\HttpResponseStatus;

final class NyholmResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param string|resource|StreamInterface|null $body Response body
     * @param array<string, string> $headers
     */
    public function create(
        $body = null,
        int $status = HttpResponseStatus::OK,
        array $headers = [],
        string $version = '1.1',
        string $reason = null
    ): ResponseInterface {
        $response = new Response($status, $headers, $body, $version, $reason);
        $response->getBody()->rewind();

        return $response;
    }
}
