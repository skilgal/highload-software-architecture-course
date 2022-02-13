<?php

declare(strict_types=1);

namespace App\Factory;

use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;

/**
 * Container Factory.
 */
final class ContainerFactory
{
    /**
     * Get container.
     *
     * @return ContainerInterface
     * @throws Exception
     */
    public function createInstance(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/../config/container.php');
        return $containerBuilder->build();
    }
}