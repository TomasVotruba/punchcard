<?php

namespace TomasVotruba\PunchCard;

final class QueueConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[][]
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
     * @param bool[][] $connections
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
