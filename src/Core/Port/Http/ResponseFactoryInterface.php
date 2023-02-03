<?php

declare(strict_types=1);

namespace Saul\Core\Port\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Saul\PhpExtension\Http\HttpResponseStatus;

interface ResponseFactoryInterface
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
    ): ResponseInterface;
}
