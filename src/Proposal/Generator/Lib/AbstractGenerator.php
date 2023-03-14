<?php

namespace TomasVotruba\PunchCard\Proposal\Generator\Lib;

abstract class AbstractGenerator implements \Illuminate\Contracts\Support\Arrayable
{
    private array $custom = [];

    public function __isset(string $name) {
        return isset($this->custom[$name]);
    }

    public function __set(string $name, $value)
    {
        $this->custom[$name] = $value;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->custom)) {
            return $this->custom[$name];
        }

        return null;
    }

    public function set(string $name, $value): self
    {
        $this->custom[$name] = $value;

        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return array_merge(get_object_vars($this), $this->custom);
    }
}
