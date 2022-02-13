<?php

declare(strict_types=1);

use App\Service\Queue\Driver\BeanstalkdQueue;
use App\Service\Queue\Driver\RedisQueue;
use App\Service\Queue\Serializer\BaseSerializer;
use App\Service\QueueFacade;
use Pheanstalk\Contract\PheanstalkInterface;
use Pheanstalk\Pheanstalk;
use Predis\Client;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\Psr17\SlimPsr17Factory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;

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

    QueueFacade::class => function (ContainerInterface $container) {
        $processors = [];
        $settings = $container->get('settings');
        $beanstalkdSettings = $settings['beanstalkd']['server'] ?? [];
        if ($beanstalkdSettings) {
            $beanstalkd = Pheanstalk::create(
                $beanstalkdSettings['host'] ?? '127.0.0.1',
                11300
            );
            $processors['beanstalkd'] = new BeanstalkdQueue(
                $beanstalkd,
                PheanstalkInterface::DEFAULT_TUBE,
                new BaseSerializer()
            );
        }

        $aofServerSettings = $settings['redis']['aof_server'] ?? [];
        if ($aofServerSettings) {
            $redisAof = new Client([
                'scheme' => 'tcp',
                'host'   => $aofServerSettings['host'] ?? '127.0.0.1',
                'port'   => 6379,
            ], $settings['redis']['options'] ?? null);
            $processors['redis_aof'] = new RedisQueue(
                $redisAof,
                'test_queue',
                new BaseSerializer()
            );
        }

        $rdbServerSettings = $settings['redis']['rdb_server'] ?? [];
        if ($rdbServerSettings) {
            $redisRdb = new Client([
                'scheme' => 'tcp',
                'host'   => $rdbServerSettings['host'] ?? '127.0.0.1',
                'port'   => 6379,
            ], $settings['redis']['options'] ?? null);
            $processors['redis_rdb'] = new RedisQueue(
                $redisRdb,
                'test_queue',
                new BaseSerializer()
            );
        }

        return new QueueFacade($processors);
    }
];