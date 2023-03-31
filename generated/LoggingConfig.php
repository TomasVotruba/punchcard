<?php

namespace TomasVotruba\PunchCard;

class LoggingConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[]
     */
    private array $deprecations = [];

    /**
     * @var string[][]
     */
    private array $channels = [];

    public static function make(): self
    {
        return new self();
    }

    public function defaults(): self
    {
        $this->default(env('LOG_CHANNEL', 'stack'));
        $this->deprecations([
            'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
            'trace' => false,
        ]);
        $this->channels([
            'stack' => [
                'driver' => 'stack',
                'channels' => [
                    'single',
                ],
                'ignore_exceptions' => false,
            ],
            'single' => [
                'driver' => 'single',
                'path' => storage_path('logs/laravel.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ],
            'daily' => [
                'driver' => 'daily',
                'path' => storage_path('logs/laravel.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'days' => 14,
                'replace_placeholders' => true,
            ],
            'slack' => [
                'driver' => 'slack',
                'url' => env('LOG_SLACK_WEBHOOK_URL'),
                'username' => 'Laravel Log',
                'emoji' => ':boom:',
                'level' => env('LOG_LEVEL', 'critical'),
                'replace_placeholders' => true,
            ],
            'papertrail' => [
                'driver' => 'monolog',
                'level' => env('LOG_LEVEL', 'debug'),
                'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
                'handler_with' => [
                    'host' => env('PAPERTRAIL_URL'),
                    'port' => env('PAPERTRAIL_PORT'),
                    'connectionString' => 'tls://' . env('PAPERTRAIL_URL') . ':' . env('PAPERTRAIL_PORT'),
                ],
                'processors' => [
                    PsrLogMessageProcessor::class,
                ],
            ],
            'stderr' => [
                'driver' => 'monolog',
                'level' => env('LOG_LEVEL', 'debug'),
                'handler' => StreamHandler::class,
                'formatter' => env('LOG_STDERR_FORMATTER'),
                'with' => [
                    'stream' => 'php://stderr',
                ],
                'processors' => [
                    PsrLogMessageProcessor::class,
                ],
            ],
            'syslog' => [
                'driver' => 'syslog',
                'level' => env('LOG_LEVEL', 'debug'),
                'facility' => LOG_USER,
                'replace_placeholders' => true,
            ],
            'errorlog' => [
                'driver' => 'errorlog',
                'level' => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ],
            'null' => [
                'driver' => 'monolog',
                'handler' => NullHandler::class,
            ],
            'emergency' => [
                'path' => storage_path('logs/laravel.log'),
            ],
        ]);
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */
    /**
     * @param bool[] $deprecations
     */
    public function deprecations(array $deprecations): self
    {
        $this->deprecations = $deprecations;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */
    /**
     * @param string[][] $channels
     */
    public function channels(array $channels): self
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'deprecations' => $this->deprecations,
            'channels' => $this->channels,
        ];
    }
}
