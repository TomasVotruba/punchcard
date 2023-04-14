<?php

namespace TomasVotruba\PunchCard;

class BroadcastingConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var string[][]
     */
    private array $connections = [];

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
        $config->default(env('BROADCAST_DRIVER', 'null'));
        $config->connections([
            'pusher' => [
                'driver' => 'pusher',
                'key' => env('PUSHER_APP_KEY'),
                'secret' => env('PUSHER_APP_SECRET'),
                'app_id' => env('PUSHER_APP_ID'),
                'options' => [
                    'host' => env('PUSHER_HOST') ?: 'api-' . env('PUSHER_APP_CLUSTER', 'mt1') . '.pusher.com',
                    'port' => env('PUSHER_PORT', 443),
                    'scheme' => env('PUSHER_SCHEME', 'https'),
                    'encrypted' => \true,
                    'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
                ],
                'client_options' => [],
            ],
            'ably' => [
                'driver' => 'ably',
                'key' => env('ABLY_KEY'),
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
            ],
            'log' => [
                'driver' => 'log',
            ],
            'null' => [
                'driver' => 'null',
            ],
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */
    /**
     * @param string[][] $connections
     */
    public function connections(array $connections): self
    {
        $this->connections = $connections;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'connections' => $this->connections,
        ];
    }
}
