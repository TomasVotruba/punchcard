<?php

namespace TomasVotruba\PunchCard;

final class HashingConfig
{
    private string $driver;

    /**
     * @var string[]
     */
    private array $bcrypt = [];

    /**
     * @var string[]
     */
    private array $argon = [];

    public static function make(): self
    {
        return new self();
    }

    public function driver(string $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param string[] $bcrypt
     */
    public function bcrypt(array $bcrypt): self
    {
        $this->bcrypt = $bcrypt;
        return $this;
    }

    /**
     * @param string[] $argon
     */
    public function argon(array $argon): self
    {
        $this->argon = $argon;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'driver' => $this->driver,
            'bcrypt' => $this->bcrypt,
            'argon' => $this->argon,
        ];
    }
}
