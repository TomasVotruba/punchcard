<?php

namespace TomasVotruba\PunchCard;

class DatabaseConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[][]
     */
    private array $connections = [];

    private ?string $migrations = null;

    /**
     * @var string[][]
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
     * @param bool[][] $connections
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
     * @param string[][] $redis
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
