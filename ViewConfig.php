<?php

namespace TomasVotruba\PunchCard;

final class ViewConfig
{
    /**
     * @var string[]
     */
    private array $paths = [];

    public static function create()
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

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return ['paths' => $this->paths];
    }
}

