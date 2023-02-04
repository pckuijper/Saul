<?php

declare(strict_types=1);

namespace Saul\PhpExtension\DateTime;

use DateTimeImmutable;
use Exception;
use Stringable;

final class Date implements Stringable
{
    private const DEFAULT_FORMAT = 'Y-m-d';

    private DateTimeImmutable $date;

    public function __construct(string $date)
    {
        $date = DateTimeImmutable::createFromFormat(
            self::DEFAULT_FORMAT,
            $date
        );

        if ($date === false) {
            throw new Exception('Unable to create date, invalid date given. Please use format [' . self::DEFAULT_FORMAT . ']');
        }

        $this->date = $date->setTime(0, 0);
    }

    public function __toString(): string
    {
        return $this->date->format(self::DEFAULT_FORMAT);
    }
}
