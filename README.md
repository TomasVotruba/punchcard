# Lazy and strict way to configure your Laravel projects

## Installation

```bash
composer require tomasvotruba/punchcard
```

## Usage

This package provides basic fluent config classes for the Laravel project [`/config`](https://github.com/laravel/laravel/tree/10.x/config) directory.

You can use the right away after installing this package, e.g. in your `config/app.php`:

```php
<?php

declare(strict_types=1);

use TomasVotruba\PunchCard\CacheConfig;

return CacheConfig::make()
    ->default(env('CACHE_DRIVER', 'file'))
    ->stores([
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ])
    ->toArray();
```


<br>

Happy coding!
