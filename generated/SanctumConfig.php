<?php

namespace TomasVotruba\PunchCard;

class SanctumConfig implements \Illuminate\Contracts\Support\Arrayable
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
     * @var array<class-string<\App\Http\Middleware\EncryptCookies>>
     */
    private array $middleware = [];

    public static function make(): self
    {
        return new self();
    }

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Requests from the following domains / hosts will receive stateful API
    | authentication cookies. Typically, these should include your local
    | and production domains which access your API via a frontend SPA.
    |
    */
    /**
     * @param string[] $stateful
     */
    public function stateful(array $stateful): self
    {
        $this->stateful = $stateful;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | This array contains the authentication guards that will be checked when
    | Sanctum is trying to authenticate a request. If none of these guards
    | are able to authenticate the request, Sanctum will use the bearer
    | token that's present on an incoming request for authentication.
    |
    */
    /**
     * @param string[] $guard
     */
    public function guard(array $guard): self
    {
        $this->guard = $guard;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | considered expired. If this value is null, personal access tokens do
    | not expire. This won't tweak the lifetime of first-party sessions.
    |
    */
    public function expiration(?int $expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | When authenticating your first-party SPA with Sanctum you may need to
    | customize some of the middleware Sanctum uses while processing the
    | request. You may change the middleware listed below as required.
    |
    */
    /**
     * @param array<class-string<\App\Http\Middleware\EncryptCookies>> $middleware
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
