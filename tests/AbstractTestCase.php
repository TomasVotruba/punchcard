<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Tests;

use PHPUnit\Framework\TestCase;
use TomasVotruba\PunchCard\Kernel\ApplicationFactory;

abstract class AbstractTestCase extends TestCase
{
    protected function setUp(): void
    {
        $applicationBootloader = new ApplicationFactory();
        $applicationBootloader->create();
    }
}
