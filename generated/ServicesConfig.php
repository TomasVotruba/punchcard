<?php

namespace TomasVotruba\PunchCard;

class ServicesConfig implements \Illuminate\Contracts\Support\Arrayable
{
    /**
     * @var string[]
     */
    private array $mailgun = [];

    /**
     * @var ?string[]
     */
    private array $postmark = [];

    /**
     * @var string[]
     */
    private array $ses = [];

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
        $config->mailgun([
            'domain' => env('MAILGUN_DOMAIN'),
            'secret' => env('MAILGUN_SECRET'),
            'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
            'scheme' => 'https',
        ]);
        $config->postmark([
            'token' => env('POSTMARK_TOKEN'),
        ]);
        $config->ses([
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    /**
     * @param string[] $mailgun
     */
    public function mailgun(array $mailgun): self
    {
        $this->mailgun = $mailgun;
        return $this;
    }

    /**
     * @param ?string[] $postmark
     */
    public function postmark(array $postmark): self
    {
        $this->postmark = $postmark;
        return $this;
    }

    /**
     * @param string[] $ses
     */
    public function ses(array $ses): self
    {
        $this->ses = $ses;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'mailgun' => $this->mailgun,
            'postmark' => $this->postmark,
            'ses' => $this->ses,
        ];
    }
}
