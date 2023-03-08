<?php

namespace TomasVotruba\PunchCard;

final class FilesystemsConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[][]
     */
    private array $disks = [];

    /**
     * @var string[]
     */
    private array $links = [];

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
     * @param bool[][] $disks
     */
    public function disks(array $disks): self
    {
        $this->disks = $disks;
        return $this;
    }

    /**
     * @param string[] $links
     */
    public function links(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'disks' => $this->disks,
            'links' => $this->links,
        ];
    }
}
