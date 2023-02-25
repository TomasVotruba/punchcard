<?php

namespace TomasVotruba\PunchCard;

final class MailConfig
{
    private ?string $default = null;

    /**
     * @var string[][][]
     */
    private array $mailers = [];

    /**
     * @var string[]
     */
    private array $from = [];

    /**
     * @var string[][]
     */
    private array $markdown = [];

    public static function make(): self
    {
        return new self();
    }

    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @param string[][][] $mailers
     */
    public function mailers(array $mailers): self
    {
        $this->mailers = $mailers;
        return $this;
    }

    /**
     * @param string[] $from
     */
    public function from(array $from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param string[][] $markdown
     */
    public function markdown(array $markdown): self
    {
        $this->markdown = $markdown;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'mailers' => $this->mailers,
            'from' => $this->from,
            'markdown' => $this->markdown,
        ];
    }
}
