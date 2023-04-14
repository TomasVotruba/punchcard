<?php

namespace TomasVotruba\PunchCard;

class AppConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $name = null;

    private ?string $env = null;

    private bool $debug = false;

    private ?string $url = null;

    private ?string $assetUrl = null;

    private ?string $timezone = null;

    private ?string $locale = null;

    private ?string $fallbackLocale = null;

    private ?string $fakerLocale = null;

    private ?string $key = null;

    private ?string $cipher = null;

    /**
     * @var string[]
     */
    private array $maintenance = [];

    /**
     * @var array<class-string<\Illuminate\Support\ServiceProvider>>
     */
    private array $providers = [];

    /**
     * @var string[]
     */
    private array $aliases = [];

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
        $config->name(env('APP_NAME', 'Laravel'));
        $config->env(env('APP_ENV', 'production'));
        $config->debug((bool) env('APP_DEBUG', \false));
        $config->url(env('APP_URL', 'http://localhost'));
        $config->assetUrl(env('ASSET_URL'));
        $config->timezone('UTC');
        $config->locale('en');
        $config->fallbackLocale('en');
        $config->fakerLocale('en_US');
        $config->key(env('APP_KEY'));
        $config->cipher('AES-256-CBC');
        $config->maintenance([
            'driver' => 'file',
        ]);
        $config->providers([
            /*
             * Laravel Framework Service Providers...
             */
            \Illuminate\Auth\AuthServiceProvider::class,
            \Illuminate\Broadcasting\BroadcastServiceProvider::class,
            \Illuminate\Bus\BusServiceProvider::class,
            \Illuminate\Cache\CacheServiceProvider::class,
            \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
            \Illuminate\Cookie\CookieServiceProvider::class,
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Encryption\EncryptionServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
            \Illuminate\Hashing\HashServiceProvider::class,
            \Illuminate\Mail\MailServiceProvider::class,
            \Illuminate\Notifications\NotificationServiceProvider::class,
            \Illuminate\Pagination\PaginationServiceProvider::class,
            \Illuminate\Pipeline\PipelineServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \Illuminate\Redis\RedisServiceProvider::class,
            \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
            \Illuminate\Session\SessionServiceProvider::class,
            \Illuminate\Translation\TranslationServiceProvider::class,
            \Illuminate\Validation\ValidationServiceProvider::class,
            \Illuminate\View\ViewServiceProvider::class,
            /*
             * Package Service Providers...
             */
            /*
             * Application Service Providers...
             */
            \App\Providers\AppServiceProvider::class,
            \App\Providers\AuthServiceProvider::class,
            // App\Providers\BroadcastServiceProvider::class,
            \App\Providers\EventServiceProvider::class,
            \App\Providers\RouteServiceProvider::class,
        ]);
        $config->aliases(\Illuminate\Support\Facades\Facade::defaultAliases()->merge([])->toArray());
        return $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */
    public function env(string $env): self
    {
        $this->env = $env;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    public function debug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function assetUrl(?string $assetUrl): self
    {
        $this->assetUrl = $assetUrl;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */
    public function timezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    public function locale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    public function fallbackLocale(string $fallbackLocale): self
    {
        $this->fallbackLocale = $fallbackLocale;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */
    public function fakerLocale(string $fakerLocale): self
    {
        $this->fakerLocale = $fakerLocale;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */
    public function key(?string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function cipher(string $cipher): self
    {
        $this->cipher = $cipher;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */
    /**
     * @param string[] $maintenance
     */
    public function maintenance(array $maintenance): self
    {
        $this->maintenance = $maintenance;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */
    /**
     * @param array<class-string<\Illuminate\Support\ServiceProvider>> $providers
     */
    public function providers(array $providers): self
    {
        $this->providers = $providers;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */
    /**
     * @param string[] $aliases
     */
    public function aliases(array $aliases): self
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
