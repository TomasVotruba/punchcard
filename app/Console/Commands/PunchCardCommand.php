<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Console\Commands;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use TomasVotruba\PunchCard\FluentConfigGenerator;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    public $signature = 'app:generate {paths*}';

    /**
     * @var string
     */
    public $description = 'Generate fluent config';

    public function __construct(
        private readonly FluentConfigGenerator $fluentConfigGenerator,
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        /** @var string[] $paths */
        $paths = $this->argument('paths');

        foreach ($paths as $path) {
            $fileContents = FileSystem::read($path);

            try {
                $fluentConfigContents = $this->fluentConfigGenerator->generate($fileContents, $path);
            } catch (\Throwable $throwable) {
                $errorMessage = sprintf('Not implemented yet for %s: %s', $path, $throwable->getMessage());
                $this->error($errorMessage);
                return self::FAILURE;
            }

            $this->line(sprintf('File generated: "%s"', PHP_EOL . PHP_EOL . $fluentConfigContents));
        }

        $this->info('All done');
        return self::SUCCESS;
    }
}
