<?php

namespace TomasVotruba\PunchCard;

class FilesystemsConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $default = null;

    /**
     * @var bool[][]
     */
    private array $disks = [];

    /**
     * @var string[]
     */
    private array $links = [];

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
        $config->default(env('FILESYSTEM_DISK', 'local'));
        $config->disks([
            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
                'throw' => \false,
            ],
            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL') . '/storage',
                'visibility' => 'public',
                'throw' => \false,
            ],
            's3' => [
                'driver' => 's3',
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'region' => env('AWS_DEFAULT_REGION'),
                'bucket' => env('AWS_BUCKET'),
                'url' => env('AWS_URL'),
                'endpoint' => env('AWS_ENDPOINT'),
                'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', \false),
                'throw' => \false,
            ],
        ]);
        $config->links([
            public_path('storage') => storage_path('app/public'),
        ]);
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */
    public function default(string $default): self
    {
        $this->default = $default;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */
    /**
     * @param bool[][] $disks
     */
    public function disks(array $disks): self
    {
        $this->disks = $disks;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */
    /**
     * @param string[] $links
     */
    public function links(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'default' => $this->default,
            'disks' => $this->disks,
            'links' => $this->links,
        ];
    }
}
