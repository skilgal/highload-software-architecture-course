<?php

declare(strict_types=1);

use App\Application\Action\HomeAction;
use App\Application\Action\SearchAction;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeAction::class)->setName('home');
    $app->get('/search', SearchAction::class)->setName('search');
};