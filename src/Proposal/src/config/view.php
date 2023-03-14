<?php

use TomasVotruba\PunchCard\Proposal\Generator\Lib\ViewConfig;

return (new ViewConfig)->toArray(); // Ship with default settings

return (new ViewConfig)->set('a', 'b')->toArray();

$view = (new ViewConfig);

$view->a = 'b';

return $view->toArray();
