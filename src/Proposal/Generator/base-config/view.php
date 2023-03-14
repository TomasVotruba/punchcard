<?php

return [
    'paths' => [__DIR__ . '/../resources/views'],
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
