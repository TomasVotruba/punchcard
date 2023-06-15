<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
use TomasVotruba\PunchCard\FluentConfigGenerator;
use TomasVotruba\PunchCard\ValueObject\ConfigFile;
use Webmozart\Assert\Assert;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    protected $signature = 'generate {paths*} {--output=}';

    /**
     * @var string
     */
    protected $description = 'Generate fluent config class from provided directory';

    public function __construct(
        private readonly FluentConfigGenerator $fluentConfigGenerator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);

        /** @var string[] $paths */
        $paths = $this->argument('paths');

        // normalize to files
        $filePaths = $this->normalizeToFiles($paths);

        foreach ($filePaths as $filePath) {
            /** @var string $fileContents */
            $fileContents = file_get_contents($filePath);

            $configFile = new ConfigFile($filePath, $fileContents);

            try {
                $fluentConfigContents = $this->fluentConfigGenerator->generate($configFile);
            } catch (Throwable $throwable) {
                $errorMessage = sprintf('Failed for "%s":%s%s', $filePath, PHP_EOL, $throwable->getMessage());
                $symfonyStyle->error($errorMessage);

                return self::FAILURE;
            }

            $outputDirectory = $this->option('output');
            if (is_string($outputDirectory)) {
                $outputFilePath = $this->resolveOutputFilePath($fluentConfigContents, $outputDirectory);
                file_put_contents($outputFilePath, $fluentConfigContents);

                $symfonyStyle->success(sprintf('File was generated to "%s"', $outputFilePath));
            } else {
                $this->line(sprintf('Generated config contents: "%s"', PHP_EOL . PHP_EOL . $fluentConfigContents));
            }
        }

        $this->newLine();
        $symfonyStyle->success('Generating finished');

        return self::SUCCESS;
    }

    private function resolveOutputFilePath(string $fluentConfigContents, string $outputDirectory): string
    {
        // generate to file path
        $shortClassName = str($fluentConfigContents)
            ->match('#class (\w+)#')
            ->value();

        Assert::notEmpty($shortClassName);

        return $outputDirectory . '/' . $shortClassName . '.php';
    }

    /**
     * @param string[] $paths
     * @return string[]
     */
    private function normalizeToFiles(array $paths): array
    {
        $filePaths = [];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $currentFilePaths = glob($path . '/*.php', GLOB_BRACE);
                if (! is_array($currentFilePaths)) {
                    continue;
                }

                $filePaths = [...$filePaths, ...$currentFilePaths];
            } else {
                $filePaths[] = $path;
            }
        }

        Assert::allString($filePaths);

        return $filePaths;
    }
}
