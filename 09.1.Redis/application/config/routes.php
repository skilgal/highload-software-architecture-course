<?php

declare(strict_types=1);

use App\Application\Action\ViewUserAction;
use Slim\App;

return function (App $app) {
    $app->get('/user', ViewUserAction::class);
};
