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

final class ViewConfig implements \Illuminate\Contracts\Support\Arrayable
{
    private ?string $compiled = null;

    public static function make(): self
    {
        return new self();
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
