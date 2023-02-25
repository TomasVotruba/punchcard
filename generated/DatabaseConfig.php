<?php

namespace TomasVotruba\PunchCard;

final class DatabaseConfig
{
    private string $default;

    /**
     * @var string[]
     */
    private array $connections = [];

    private string $migrations;

    /**
     * @var string[]
     */
    private array $redis = [];

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
     * @param string[] $connections
     */
    public function connections(array $connections): self
    {
        $this->connections = $connections;
        return $this;
    }

    public function migrations(string $migrations): self
    {
        $this->migrations = $migrations;
        return $this;
    }

    /**
     * @param string[] $redis
     */
    public function redis(array $redis): self
    {
        $this->redis = $redis;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'connections' => $this->connections,
            'migrations' => $this->migrations,
            'redis' => $this->redis,
        ];
    }
}
