<?php

namespace TomasVotruba\PunchCard\Proposal\src\Usage;

class DummyClass
{
    public function index()
    {
        config('view.a');
        config('view:a');

        // Package example
//        $this->mergeConfigFrom(
//            __DIR__.'/path/to/config/view.php', 'view'
//        );
    }
}
