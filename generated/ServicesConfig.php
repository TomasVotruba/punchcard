<?php

namespace TomasVotruba\PunchCard;

final class ServicesConfig
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

    public static function make(): self
    {
        return new self();
    }

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
