# Lazy and strict way to configure your Laravel projects

I love Laravel, but I'm very bad at working with array. I use wrong keys, delete items that are needed and my project kept crashing. So I made this project to help me with that.

<br>

## Installation

```bash
composer require tomasvotruba/punchcard
```

<br>

## Usage

This package provides basic fluent config classes for the Laravel project [`/config`](https://github.com/laravel/laravel/tree/10.x/config) directory.

You can use the right away after installing this package, e.g. in your `config/cache.php`:

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
