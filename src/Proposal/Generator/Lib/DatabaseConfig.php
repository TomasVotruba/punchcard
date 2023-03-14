<?php

namespace TomasVotruba\PunchCard\Proposal\Generator\Lib;

class DatabaseConfig extends AbstractGenerator
{
    // BUNCH SETTERS

    public string $default = 'mysql';

    public function use(DatabaseInterface $config): self
    {
        switch ($config) {
            case 1:
                $this->default = '1';
                break;
            default:
                $this->default = 'mysql';
        }

        return $this;
    }
}
