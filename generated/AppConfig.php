<?php

namespace TomasVotruba\PunchCard;

final class AppConfig
{
    private string $name;

    private string $env;

    private bool $debug;

    private string $url;

    private string $assetUrl;

    private string $timezone;

    private string $locale;

    private string $fallbackLocale;

    private string $fakerLocale;

    private string $key;

    private string $cipher;

    /**
     * @var string[]
     */
    private array $maintenance = [];

    /**
     * @var string[]
     */
    private array $providers = [];

    private mixed $aliases;

    public static function make(): self
    {
        return new self();
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function env(string $env): self
    {
        $this->env = $env;
        return $this;
    }

    public function debug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function assetUrl(string $assetUrl): self
    {
        $this->assetUrl = $assetUrl;
        return $this;
    }

    public function timezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function locale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function fallbackLocale(string $fallbackLocale): self
    {
        $this->fallbackLocale = $fallbackLocale;
        return $this;
    }

    public function fakerLocale(string $fakerLocale): self
    {
        $this->fakerLocale = $fakerLocale;
        return $this;
    }

    public function key(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function cipher(string $cipher): self
    {
        $this->cipher = $cipher;
        return $this;
    }

    /**
     * @param string[] $maintenance
     */
    public function maintenance(array $maintenance): self
    {
        $this->maintenance = $maintenance;
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

    public function aliases(mixed $aliases): self
    {
        $this->aliases = $aliases;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'env' => $this->env,
            'debug' => $this->debug,
            'url' => $this->url,
            'asset_url' => $this->assetUrl,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'fallback_locale' => $this->fallbackLocale,
            'faker_locale' => $this->fakerLocale,
            'key' => $this->key,
            'cipher' => $this->cipher,
            'maintenance' => $this->maintenance,
            'providers' => $this->providers,
            'aliases' => $this->aliases,
        ];
    }
}
