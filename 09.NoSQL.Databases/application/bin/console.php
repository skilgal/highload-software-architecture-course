<?php

declare(strict_types=1);

require_once (dirname(__DIR__) . '/vendor/autoload.php');

$env = (new \Symfony\Component\Console\Input\ArgvInput())->getParameterOption(['--env', '-e'], 'dev');

if ($env) {
    $_ENV['APP_ENV'] = $env;
}

$container = (new \App\Factory\ContainerFactory())->createInstance();

try {
    /** @var \Symfony\Component\Console\Application $application */
    $application = $container->get(\Symfony\Component\Console\Application::class);
    exit($application->run());
} catch (\Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}