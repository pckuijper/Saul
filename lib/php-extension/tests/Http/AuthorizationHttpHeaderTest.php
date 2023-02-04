<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Test\Http;

use Saul\PhpExtension\Http\AuthorizationHttpHeader;
use Saul\Test\Framework\AbstractSaulTestcase;

/**
 * @small
 *
 * @micro
 */
final class AuthorizationHttpHeaderTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function should_format_bearer_header_type(): void
    {
        $credentials = 'credentials';
        self::assertSame('Bearer ' . $credentials, AuthorizationHttpHeader::bearer($credentials));
    }
}
