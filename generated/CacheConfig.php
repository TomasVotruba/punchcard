<?php

namespace TomasVotruba\PunchCard;

final class CacheConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var mixed[]
     */
    private array $stores = [];

    private ?string $prefix = null;

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
     * @param mixed[] $stores
     */
    public function stores(array $stores): self
    {
        $this->stores = $stores;
        return $this;
    }

    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'stores' => $this->stores,
            'prefix' => $this->prefix,
        ];
    }
}
