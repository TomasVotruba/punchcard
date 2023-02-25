<?php

namespace TomasVotruba\PunchCard;

final class SessionConfig
{
    private string $driver;

    private int $lifetime;

    private bool $expireOnClose;

    private bool $encrypt;

    private string $files;

    private ?string $connection = null;

    private string $table;

    private ?string $store = null;

    /**
     * @var string[]
     */
    private array $lottery = [];

    private string $cookie;

    private string $path;

    private ?string $domain = null;

    private ?string $secure = null;

    private bool $httpOnly;

    private string $sameSite;

    public static function make(): self
    {
        return new self();
    }

    public function driver(string $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    public function lifetime(int $lifetime): self
    {
        $this->lifetime = $lifetime;
        return $this;
    }

    public function expireOnClose(bool $expireOnClose): self
    {
        $this->expireOnClose = $expireOnClose;
        return $this;
    }

    public function encrypt(bool $encrypt): self
    {
        $this->encrypt = $encrypt;
        return $this;
    }

    public function files(string $files): self
    {
        $this->files = $files;
        return $this;
    }

    public function connection(?string $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function store(?string $store): self
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @param string[] $lottery
     */
    public function lottery(array $lottery): self
    {
        $this->lottery = $lottery;
        return $this;
    }

    public function cookie(string $cookie): self
    {
        $this->cookie = $cookie;
        return $this;
    }

    public function path(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function domain(?string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function secure(?string $secure): self
    {
        $this->secure = $secure;
        return $this;
    }

    public function httpOnly(bool $httpOnly): self
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    public function sameSite(string $sameSite): self
    {
        $this->sameSite = $sameSite;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'driver' => $this->driver,
            'lifetime' => $this->lifetime,
            'expire_on_close' => $this->expireOnClose,
            'encrypt' => $this->encrypt,
            'files' => $this->files,
            'connection' => $this->connection,
            'table' => $this->table,
            'store' => $this->store,
            'lottery' => $this->lottery,
            'cookie' => $this->cookie,
            'path' => $this->path,
            'domain' => $this->domain,
            'secure' => $this->secure,
            'http_only' => $this->httpOnly,
            'same_site' => $this->sameSite,
        ];
    }
}
