<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Console;

use Illuminate\Foundation\Console\Kernel;

final class ConsoleKernel extends Kernel
{
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
