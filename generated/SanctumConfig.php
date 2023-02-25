<?php

namespace TomasVotruba\PunchCard;

final class SanctumConfig
{
    /**
     * @var string[]
     */
    private array $stateful = [];

    /**
     * @var string[]
     */
    private array $guard = [];

    private ?int $expiration = null;

    /**
     * @var string[]
     */
    private array $middleware = [];

    public static function make(): self
    {
        return new self();
    }

    /**
     * @param string[] $stateful
     */
    public function stateful(array $stateful): self
    {
        $this->stateful = $stateful;
        return $this;
    }

    /**
     * @param string[] $guard
     */
    public function guard(array $guard): self
    {
        $this->guard = $guard;
        return $this;
    }

    public function expiration(?int $expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    /**
     * @param string[] $middleware
     */
    public function middleware(array $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'stateful' => $this->stateful,
            'guard' => $this->guard,
            'expiration' => $this->expiration,
            'middleware' => $this->middleware,
        ];
    }
}
