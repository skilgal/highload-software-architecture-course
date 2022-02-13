<?php

declare(strict_types=1);

namespace App\Service\Queue\Driver;

use App\Exception\IllegalStateException;
use App\Service\Queue\Envelope;
use App\Service\Queue\QueueInterface;
use App\Service\Queue\Serializer\SerializerInterface;
use Pheanstalk\Contract\PheanstalkInterface;

final class BeanstalkdQueue implements QueueInterface
{
    use HasDefaultRemoveAndElement;

    /** @var PheanstalkInterface */
    private PheanstalkInterface $client;

    /** @var string */
    private string $queueName;

    /** @var SerializerInterface|null */
    private ?SerializerInterface $serializer;

    /**
     * @param PheanstalkInterface $client
     * @param string $queueName
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        PheanstalkInterface $client,
        string $queueName = PheanstalkInterface::DEFAULT_TUBE,
        ?SerializerInterface $serializer = null
    ) {
        $this->client = $client;
        $this->queueName = $queueName;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function add(Envelope $envelope): bool
    {
        if (!$this->offer($envelope)) {
            throw new IllegalStateException('Could not write to beanstalkd');
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function offer(Envelope $envelope): bool
    {
        $serialized = $this->serializer->serialize($envelope);

        return (bool) $this->client
            ->useTube($this->queueName)
            ->put($serialized);
    }

    /**
     * @inheritDoc
     */
    public function poll(): ?Envelope
    {
        $job = $this->client
            ->watch($this->queueName)
            ->reserveWithTimeout(0);

        if (empty($job)) {
            return null;
        }

        $serialized = $job->getData();
        $this->client->delete($job);
        if (empty($serialized)) {
            return null;
        }

        return $this->serializer->deserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function peek(): ?Envelope
    {
        $job = $this->client
            ->watch($this->queueName)
            ->peekReady();

        if (empty($job)) {
            return null;
        }

        $serialized = $job->getData();
        if (empty($serialized)) {
            return null;
        }

        return $this->serializer->deserialize($serialized);
    }
}
