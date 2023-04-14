<?php

namespace TomasVotruba\PunchCard;

class CacheConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var mixed[]
     */
    private array $stores = [];

    private ?string $prefix = null;

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
        $config->default(env('CACHE_DRIVER', 'file'));
        $config->stores([
            'apc' => [
                'driver' => 'apc',
            ],
            'array' => [
                'driver' => 'array',
                'serialize' => \false,
            ],
            'database' => [
                'driver' => 'database',
                'table' => 'cache',
                'connection' => \null,
                'lock_connection' => \null,
            ],
            'file' => [
                'driver' => 'file',
                'path' => storage_path('framework/cache/data'),
            ],
            'memcached' => [
                'driver' => 'memcached',
                'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
                'sasl' => [
                    env('MEMCACHED_USERNAME'),
                    env('MEMCACHED_PASSWORD'),
                ],
                'options' => [],
                'servers' => [
                    [
                        'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                        'port' => env('MEMCACHED_PORT', 11211),
                        'weight' => 100,
                    ],
                ],
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'cache',
                'lock_connection' => 'default',
            ],
            'dynamodb' => [
                'driver' => 'dynamodb',
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
                'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
                'endpoint' => env('DYNAMODB_ENDPOINT'),
            ],
            'octane' => [
                'driver' => 'octane',
            ],
        ]);
        $config->prefix(env('CACHE_PREFIX', \Illuminate\Support\Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache_'));
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "apc", "array", "database", "file",
    |         "memcached", "redis", "dynamodb", "octane", "null"
    |
    */
    /**
     * @param mixed[] $stores
     */
    public function stores(array $stores): self
    {
        $this->stores = $stores;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, or DynamoDB cache
    | stores there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */
    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'stores' => $this->stores,
            'prefix' => $this->prefix,
        ];
    }
}
