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

    public static function makeWithDefaults(): self
    {
        $config = new self();
        $config->driver('bcrypt');
        $config->bcrypt([
            'rounds' => env('BCRYPT_ROUNDS', 10),
        ]);
        $config->argon([
            'memory' => 65536,
            'threads' => 1,
            'time' => 4,
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to hash
    | passwords for your application. By default, the bcrypt algorithm is
    | used; however, you remain free to modify this option if you wish.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */
    public function driver(string $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Bcrypt algorithm. This will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */
    /**
     * @param int[] $bcrypt
     */
    public function bcrypt(array $bcrypt): self
    {
        $this->bcrypt = $bcrypt;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */
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
