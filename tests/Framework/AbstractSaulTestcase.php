<?php

declare(strict_types=1);

namespace Saul\Test\Framework;

use PHPUnit\Framework\TestCase;

abstract class AbstractSaulTestcase extends TestCase
{
    private TestApp $app;

    public function getApp(): TestApp
    {
        return $this->app = $this->app ?? new TestApp();
    }
}
