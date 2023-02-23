<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Kernel;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Http\Kernel;

/**
 * @api
 */
final class PunchcardKernel
{
    public function bootApplication(): void
    {
        // provide project base path
        $application = new Application(__DIR__ . '/../..');

        // provide base exception handler - @todo how to minimize this one?
        $application->singleton(
            ExceptionHandler::class,
            Handler::class,
        );

        /** @var Kernel $kernel */
        $kernel = $application->make(Kernel::class);
        $kernel->bootstrap();
    }
}
