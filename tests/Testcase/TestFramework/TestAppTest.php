<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\TestFramework;

use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\TestApp;
use Symfony\Component\Console\Command\Command;

/**
 * @small
 *
 * @group functional
 */
final class TestAppTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_can_run_cli_commands(): void
    {
        $testApp = new TestApp();

        $result = $testApp->runCliCommand('about');

        self::assertSame(Command::SUCCESS, $result->statusCode);
        self::assertNotEmpty($result->output);
    }
}
