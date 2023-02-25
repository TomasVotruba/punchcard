<?php

namespace TomasVotruba\PunchCard;

final class LoggingConfig
{
    private string $default;

    /**
     * @var string[]
     */
    private array $deprecations = [];

    /**
     * @var string[]
     */
    private array $channels = [];

    public static function make(): self
    {
        return new self();
    }

    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @param string[] $deprecations
     */
    public function deprecations(array $deprecations): self
    {
        $this->deprecations = $deprecations;
        return $this;
    }

    /**
     * @param string[] $channels
     */
    public function channels(array $channels): self
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'deprecations' => $this->deprecations,
            'channels' => $this->channels,
        ];
    }
}
