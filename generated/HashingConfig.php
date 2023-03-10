<?php

namespace TomasVotruba\PunchCard;

class HashingConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $driver = null;

    /**
     * @var int[]
     */
    private array $bcrypt = [];

    /**
     * @var int[]
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
     * @param int[] $bcrypt
     */
    public function bcrypt(array $bcrypt): self
    {
        $this->bcrypt = $bcrypt;
        return $this;
    }

    /**
     * @param int[] $argon
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
