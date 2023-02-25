<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Commands;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use TomasVotruba\PunchCard\FluentConfigGenerator;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    public $signature = 'app:generate {paths*} {--output=}';

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

            $outputDirectory = $this->option('output');
            if ($outputDirectory) {
                $outputFilePath = $this->resolveOutputFilePath($fluentConfigContents, $outputDirectory);
                FileSystem::write($outputFilePath, $fluentConfigContents);

                $this->line(sprintf('File was generated to "%s"', $outputFilePath));
            } else {
                $this->line(sprintf('Generated config contents: "%s"', PHP_EOL . PHP_EOL . $fluentConfigContents));
            }
        }

        $this->newLine();
        $this->info('Generating finished');

        return self::SUCCESS;
    }

    private function resolveOutputFilePath(string $fluentConfigContents, string $outputDirectory): string
    {
        // generate to file path
        $shortClassName = str($fluentConfigContents)
            ->match('#class (\w+)#')
            ->value();

        return $outputDirectory . '/' . $shortClassName . '.php';
    }
}
