<?php

namespace TomasVotruba\PunchCard\Proposal\Generator\Lib;

class ViewConfig extends AbstractGenerator
{
    /**
     * @var string[]
     */
    public array $paths = [__DIR__ . '/../resources/views'];

    public ?string $compiled;

    public function __construct()
    {
        $this->compiled = env(
            'VIEW_COMPILED_PATH',
            realpath(storage_path('framework/views'))
        );
    }

    /**
     * @param string[] $paths
     */
    public function setPaths(array $paths): self
    {
        $this->paths = $paths;

        return $this;
    }

    public function setCompiled(string $compiled): self
    {
        $this->compiled = $compiled;

        return $this;
    }
}
