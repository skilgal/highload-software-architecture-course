<?php

declare(strict_types=1);

use App\Application\Action\ReadAction;
use App\Application\Action\WriteAction;
use Slim\App;

return function (App $app) {
    $app->get('/read/{queue}', ReadAction::class);
    $app->get('/write/{queue}', WriteAction::class);
};
