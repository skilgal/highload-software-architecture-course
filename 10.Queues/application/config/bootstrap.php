<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$container = (new \App\Factory\ContainerFactory())->createInstance();

return $container->get(\Slim\App::class);