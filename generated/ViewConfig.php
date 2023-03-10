<?php

namespace TomasVotruba\PunchCard;

class ViewConfig implements \Illuminate\Contracts\Support\Arrayable
{
    /**
     * @var string[]
     */
    private array $paths = [];

    private ?string $compiled = null;

    public static function make(): self
    {
        return new self();
    }

    /**
     * @param string[] $paths
     */
    public function paths(array $paths): self
    {
        $this->paths = $paths;
        return $this;
    }

    public function compiled(string $compiled): self
    {
        $this->compiled = $compiled;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'paths' => $this->paths,
            'compiled' => $this->compiled,
        ];
    }
}
