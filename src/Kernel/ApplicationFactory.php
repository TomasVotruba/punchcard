<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Kernel;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Http\Kernel;
use TomasVotruba\PunchCard\Console\ConsoleKernel;

/**
 * @api
 */
final class ApplicationFactory
{
    public function create(): Application
    {
        // provide project base path
        $application = new Application(__DIR__ . '/../..');

        // provide base exception handler - @todo how to minimize this one?
        $application->singleton(
            ExceptionHandler::class,
            Handler::class,
        );

        $application->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            ConsoleKernel::class,
        );

        /** @var Kernel $kernel */
        $kernel = $application->make(Kernel::class);
        $kernel->bootstrap();

        return $application;
    }
}
