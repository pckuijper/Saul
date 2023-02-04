<?php

declare(strict_types=1);

namespace Saul\PhpExtension\Test\DateTime;

use Saul\PhpExtension\DateTime\Date;
use Saul\Test\Framework\AbstractSaulTestcase;

/**
 * @small
 *
 * @micro
 */
final class DateTest extends AbstractSaulTestcase
{
    /**
     * @test
     *
     * @dataProvider dateProvider
     */
    public function it_can_be_created_with_given_date(string $givenDate): void
    {
        $givenDate = '2022-02-01';

        $date = new Date($givenDate);

        self::assertSame($givenDate, (string) $date);
    }

    public function dateProvider(): array
    {
        return [
            'My birthday' => ['2022-02-21'],
            'Wifes birtday' => ['2022-03-30'],
            'Date of birth' => ['1992-02-21'],
            'New years day' => ['2022-01-01'],
        ];
    }
}
