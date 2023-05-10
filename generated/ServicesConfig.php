<?php

namespace TomasVotruba\PunchCard;

class ServicesConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private array $parameters = [];

    public static function make(): self
    {
        return new self();
    }

    public function service(array $parameters): void
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return $this->parameters;
    }
}
