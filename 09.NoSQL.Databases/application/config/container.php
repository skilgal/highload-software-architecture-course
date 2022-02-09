<?php

declare(strict_types=1);

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\Psr17\SlimPsr17Factory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);
        (require __DIR__ . '/routes.php')($app);
        (require __DIR__ . '/middleware.php')($app);

        return $app;
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(SlimPsr17Factory::class)->getResponseFactory();
    },

    ServerRequestFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(SlimPsr17Factory::class)->getServerRequestCreator();
    },

    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    Application::class => function (ContainerInterface $container) {
        $application = new Application();

        $application->getDefinition()->addOption(
            new InputOption(
                '--env',
                '-e',
                InputOption::VALUE_REQUIRED,
                'The Environment name.',
                'development'
            )
        );

        foreach ($container->get('settings')['commands'] as $class) {
            $application->add($container->get($class));
        }

        return $application;
    },

    Client::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['elasticsearch'];
        $client = ClientBuilder::create();
        $client->setHosts($settings['hosts']);
        return $client->build();
    }
];