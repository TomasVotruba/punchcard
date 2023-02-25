<?php

namespace TomasVotruba\PunchCard;

final class BroadcastingConfig
{
    private ?string $default = null;

    /**
     * @var string[][]
     */
    private array $connections = [];

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
     * @param string[][] $connections
     */
    public function connections(array $connections): self
    {
        $this->connections = $connections;
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
        ];
    }
}
