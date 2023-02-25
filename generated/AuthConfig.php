<?php

namespace TomasVotruba\PunchCard;

final class AuthConfig
{
    /**
     * @var string[]
     */
    private array $defaults = [];

    /**
     * @var string[]
     */
    private array $guards = [];

    /**
     * @var string[]
     */
    private array $providers = [];

    /**
     * @var string[]
     */
    private array $passwords = [];

    private int $passwordTimeout;

    public static function make(): self
    {
        return new self();
    }

    /**
     * @param string[] $defaults
     */
    public function defaults(array $defaults): self
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * @param string[] $guards
     */
    public function guards(array $guards): self
    {
        $this->guards = $guards;
        return $this;
    }

    /**
     * @param string[] $providers
     */
    public function providers(array $providers): self
    {
        $this->providers = $providers;
        return $this;
    }

    /**
     * @param string[] $passwords
     */
    public function passwords(array $passwords): self
    {
        $this->passwords = $passwords;
        return $this;
    }

    public function passwordTimeout(int $passwordTimeout): self
    {
        $this->passwordTimeout = $passwordTimeout;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'defaults' => $this->defaults,
            'guards' => $this->guards,
            'providers' => $this->providers,
            'passwords' => $this->passwords,
            'password_timeout' => $this->passwordTimeout,
        ];
    }
}
