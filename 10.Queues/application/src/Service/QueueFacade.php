<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Queue\QueueInterface;
use Exception;

final class QueueFacade
{
    /** @var QueueInterface[] */
    private array $processors;

    public function __construct(array $processors = [])
    {
        $this->processors = $processors;
    }

    /**
     * @param string $queue
     * @param QueueInterface $processor
     *
     * @return $this
     * @throws Exception
     */
    public function registerProcessor(string $queue, QueueInterface $processor): self
    {
        if ($this->hasProcessor($queue)) {
            throw new Exception(sprintf('Processor "%s" is already registered.', $queue));
        }

        $this->processors[$queue] = $processor;

        return $this;
    }

    /**
     * @return array
     */
    public function getProcessors(): array
    {
        return $this->processors;
    }

    /**
     * @param string $queue
     * @return QueueInterface
     * @throws Exception
     */
    public function getProcessor(string $queue): QueueInterface
    {
        if ($this->hasProcessor($queue) === false) {
            throw new Exception(sprintf('Processor "%s" not registered.', $queue));
        }

        return $this->processors[$queue];
    }

    /**
     * @param string $queue
     * @return bool
     */
    public function hasProcessor(string $queue): bool
    {
        return isset($this->processors[$queue]);
    }
}
