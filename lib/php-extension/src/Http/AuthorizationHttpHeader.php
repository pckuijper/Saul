<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Http;

final class AuthorizationHttpHeader
{
    public const NAME = 'Authorization';

    public const TYPE_BEARER = 'Bearer';
    public const TYPE_BASIC = 'Basic';

    public static function bearer(string $credentials): string
    {
        return sprintf('%s %s', self::TYPE_BEARER, $credentials);
    }

    public static function basic(string $userName, string $password): string
    {
        return sprintf(
            '%s %s',
            self::TYPE_BASIC,
            base64_encode(
                sprintf('%s:%s', $userName, $password)
            )
        );
    }
}
