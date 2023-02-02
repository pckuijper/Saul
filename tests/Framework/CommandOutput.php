<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

final class CommandOutput
{
    public function __construct(
        public readonly int $statusCode,
        public readonly string $output
    ) {
    }
}
