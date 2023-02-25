<?php

namespace TomasVotruba\PunchCard;

final class QueueConfig
{
    private string $default;

    /**
     * @var string[]
     */
    private array $connections = [];

    /**
     * @var string[]
     */
    private array $failed = [];

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

    /**
     * @param string[] $failed
     */
    public function failed(array $failed): self
    {
        $this->failed = $failed;
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
            'failed' => $this->failed,
        ];
    }
}
