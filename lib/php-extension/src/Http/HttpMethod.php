<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Http;

enum HttpMethod
{
    case GET;
    case HEAD;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
    case OPTIONS;
}
