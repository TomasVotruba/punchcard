<?php

namespace TomasVotruba\PunchCard;

class CorsConfig implements \Illuminate\Contracts\Support\Arrayable
{
    /**
     * @var string[]
     */
    private array $paths = [];

    /**
     * @var string[]
     */
    private array $allowedMethods = [];

    /**
     * @var string[]
     */
    private array $allowedOrigins = [];

    /**
     * @var mixed[]
     */
    private array $allowedOriginsPatterns = [];

    /**
     * @var string[]
     */
    private array $allowedHeaders = [];

    /**
     * @var mixed[]
     */
    private array $exposedHeaders = [];

    private int $maxAge;

    private bool $supportsCredentials = false;

    /**
     * @deprecated Use self::make() with identical behavior
     */
    public static function makeWithDefaults(): self
    {
        return self::make();
    }

    public static function make(): self
    {
        $config = new self();
        $config->paths([
            'api/*',
            'sanctum/csrf-cookie',
        ]);
        $config->allowedMethods([
            '*',
        ]);
        $config->allowedOrigins([
            '*',
        ]);
        $config->allowedOriginsPatterns([]);
        $config->allowedHeaders([
            '*',
        ]);
        $config->exposedHeaders([]);
        $config->maxAge(0);
        $config->supportsCredentials(\false);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    /**
     * @param string[] $paths
     */
    public function paths(array $paths): self
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * @param string[] $allowed_methods
     */
    public function allowedMethods(array $allowedMethods): self
    {
        $this->allowedMethods = $allowedMethods;
        return $this;
    }

    /**
     * @param string[] $allowed_origins
     */
    public function allowedOrigins(array $allowedOrigins): self
    {
        $this->allowedOrigins = $allowedOrigins;
        return $this;
    }

    /**
     * @param mixed[] $allowed_origins_patterns
     */
    public function allowedOriginsPatterns(array $allowedOriginsPatterns): self
    {
        $this->allowedOriginsPatterns = $allowedOriginsPatterns;
        return $this;
    }

    /**
     * @param string[] $allowed_headers
     */
    public function allowedHeaders(array $allowedHeaders): self
    {
        $this->allowedHeaders = $allowedHeaders;
        return $this;
    }

    /**
     * @param mixed[] $exposed_headers
     */
    public function exposedHeaders(array $exposedHeaders): self
    {
        $this->exposedHeaders = $exposedHeaders;
        return $this;
    }

    public function maxAge(int $maxAge): self
    {
        $this->maxAge = $maxAge;
        return $this;
    }

    public function supportsCredentials(bool $supportsCredentials): self
    {
        $this->supportsCredentials = $supportsCredentials;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'paths' => $this->paths,
            'allowed_methods' => $this->allowedMethods,
            'allowed_origins' => $this->allowedOrigins,
            'allowed_origins_patterns' => $this->allowedOriginsPatterns,
            'allowed_headers' => $this->allowedHeaders,
            'exposed_headers' => $this->exposedHeaders,
            'max_age' => $this->maxAge,
            'supports_credentials' => $this->supportsCredentials,
        ];
    }
}
