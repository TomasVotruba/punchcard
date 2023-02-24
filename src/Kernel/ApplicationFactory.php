<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Kernel;

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use TomasVotruba\PunchCard\Console\Commands\PunchCardCommand;

/**
 * @api
 */
final class ApplicationFactory
{
    /**
     * @see https://stackoverflow.com/questions/43623227/is-there-a-version-of-laravel-for-console-app-only
     */
    public function create(): Application
    {
        // provide project base path
        $container = new Container();
        $dispatcher = new Dispatcher();

        $application = new Application($container, $dispatcher, '1.0');

        /** @var PunchCardCommand $punchCardCommand */
        $punchCardCommand = $container->make(PunchCardCommand::class);
        $application->add($punchCardCommand);

        return $application;
    }
}
