<?php

return [
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];

?>
-----
<?php

namespace TomasVotruba\PunchCard;

class ViewConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $compiled = null;

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
        $config->compiled(env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))));
        return $config;
    }

    public function compiled(string $compiled): self
    {
        $this->compiled = $compiled;
        return $this;
    }

    /**
     * @return array<string, mixed[]>
     */
    public function toArray(): array
    {
        return [
            'compiled' => $this->compiled,
        ];
    }
}
