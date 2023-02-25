<?php

namespace TomasVotruba\PunchCard;

final class CorsConfig
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
     * @var string[]
     */
    private array $allowedOriginsPatterns = [];

    /**
     * @var string[]
     */
    private array $allowedHeaders = [];

    /**
     * @var string[]
     */
    private array $exposedHeaders = [];

    private int $maxAge;

    private bool $supportsCredentials;

    public static function make(): self
    {
        return new self();
    }

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
     * @param string[] $allowed_origins_patterns
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
     * @param string[] $exposed_headers
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
