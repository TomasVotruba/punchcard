<?php

namespace TomasVotruba\PunchCard;

class AuthConfig implements \Illuminate\Contracts\Support\Arrayable
{
    /**
     * @var string[]
     */
    private array $defaults = [];

    /**
     * @var string[][]
     */
    private array $guards = [];

    /**
     * @var array<class-string<\App\Models\User>>[]
     */
    private array $providers = [];

    /**
     * @var int[][]
     */
    private array $passwords = [];

    private int $passwordTimeout;

    public static function make(): self
    {
        return new self();
    }

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    /**
     * @param string[] $defaults
     */
    public function defaults(array $defaults): self
    {
        $this->defaults = $defaults;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |
    */
    /**
     * @param string[][] $guards
     */
    public function guards(array $guards): self
    {
        $this->guards = $guards;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */
    /**
     * @param array<class-string<\App\Models\User>>[] $providers
     */
    public function providers(array $providers): self
    {
        $this->providers = $providers;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */
    /**
     * @param int[][] $passwords
     */
    public function passwords(array $passwords): self
    {
        $this->passwords = $passwords;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */
    public function passwordTimeout(int $passwordTimeout): self
    {
        $this->passwordTimeout = $passwordTimeout;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'defaults' => $this->defaults,
            'guards' => $this->guards,
            'providers' => $this->providers,
            'passwords' => $this->passwords,
            'password_timeout' => $this->passwordTimeout,
        ];
    }
}
