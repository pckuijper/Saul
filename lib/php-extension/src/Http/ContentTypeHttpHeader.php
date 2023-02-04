<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Http;

final class ContentTypeHttpHeader
{
    public const NAME = 'Content-Type';

    public const VALUE_APPLICATION_JSON = 'application/json';
    public const VALUE_MULTIPART = 'multipart/form-data';
    public const VALUE_APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';
}
