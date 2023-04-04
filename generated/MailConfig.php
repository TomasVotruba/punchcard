<?php

namespace TomasVotruba\PunchCard;

class MailConfig implements \Illuminate\Contracts\Support\Arrayable
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

    public static function makeWithDefaults(): self
    {
        $config = new self();
        $config->default(env('MAIL_MAILER', 'smtp'));
        $config->mailers([
            'smtp' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'timeout' => \null,
                'local_domain' => env('MAIL_EHLO_DOMAIN'),
            ],
            'ses' => [
                'transport' => 'ses',
            ],
            'mailgun' => [
                'transport' => 'mailgun',
            ],
            'postmark' => [
                'transport' => 'postmark',
            ],
            'sendmail' => [
                'transport' => 'sendmail',
                'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
            ],
            'log' => [
                'transport' => 'log',
                'channel' => env('MAIL_LOG_CHANNEL'),
            ],
            'array' => [
                'transport' => 'array',
            ],
            'failover' => [
                'transport' => 'failover',
                'mailers' => [
                    'smtp',
                    'log',
                ],
            ],
        ]);
        $config->from([
            'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example'),
        ]);
        $config->markdown([
            'theme' => 'default',
            'paths' => [
                resource_path('views/vendor/mail'),
            ],
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover"
    |
    */
    /**
     * @param string[][][] $mailers
     */
    public function mailers(array $mailers): self
    {
        $this->mailers = $mailers;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */
    /**
     * @param string[] $from
     */
    public function from(array $from): self
    {
        $this->from = $from;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */
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
