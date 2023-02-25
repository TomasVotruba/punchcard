<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject;

final class ConfigFile
{
    private readonly string $shortFileName;

    public function __construct(
        string $filePath,
        private readonly string $fileContents,
    ) {
        $this->shortFileName = str($filePath)->match('#([A-Za-z]+)\.php#')->value();
    }

    public function getShortFileName(): string
    {
        return $this->shortFileName;
    }

    public function getFileContents(): string
    {
        return $this->fileContents;
    }

    public function getClassName(): string
    {
        return ucfirst($this->shortFileName) . 'Config';
    }
}
