<?php

namespace TomasVotruba\PunchCard;

class QueueConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[][]
     */
    private array $connections = [];

    /**
     * @var string[]
     */
    private array $batching = [];

    /**
     * @var string[]
     */
    private array $failed = [];

    public static function make(): self
    {
        $config = new self();
        $config->default(env('QUEUE_CONNECTION', 'sync'));
        $config->connections([
            'sync' => [
                'driver' => 'sync',
            ],
            'database' => [
                'driver' => 'database',
                'table' => 'jobs',
                'queue' => 'default',
                'retry_after' => 90,
                'after_commit' => \false,
            ],
            'beanstalkd' => [
                'driver' => 'beanstalkd',
                'host' => 'localhost',
                'queue' => 'default',
                'retry_after' => 90,
                'block_for' => 0,
                'after_commit' => \false,
            ],
            'sqs' => [
                'driver' => 'sqs',
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
                'queue' => env('SQS_QUEUE', 'default'),
                'suffix' => env('SQS_SUFFIX'),
                'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
                'after_commit' => \false,
            ],
            'redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => env('REDIS_QUEUE', 'default'),
                'retry_after' => 90,
                'block_for' => \null,
                'after_commit' => \false,
            ],
        ]);
        $config->batching([
            'database' => env('DB_CONNECTION', 'mysql'),
            'table' => 'job_batches',
        ]);
        $config->failed([
            'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
            'database' => env('DB_CONNECTION', 'mysql'),
            'table' => 'failed_jobs',
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */
    /**
     * @param bool[][] $connections
     */
    public function connections(array $connections): self
    {
        $this->connections = $connections;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Job Batching
    |--------------------------------------------------------------------------
    |
    | The following options configure the database and table that store job
    | batching information. These options can be updated to any database
    | connection and table which has been defined by your application.
    |
    */
    /**
     * @param string[] $batching
     */
    public function batching(array $batching): self
    {
        $this->batching = $batching;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */
    /**
     * @param string[] $failed
     */
    public function failed(array $failed): self
    {
        $this->failed = $failed;
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
            'batching' => $this->batching,
            'failed' => $this->failed,
        ];
    }
}
