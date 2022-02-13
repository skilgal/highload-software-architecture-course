<?php

declare(strict_types=1);

namespace App\Service\Queue\Driver;

use App\Exception\IllegalStateException;
use App\Service\Queue\Envelope;
use App\Service\Queue\QueueInterface;
use App\Service\Queue\Serializer\SerializerInterface;
use Predis\ClientInterface;

final class RedisQueue implements QueueInterface
{
    use HasDefaultRemoveAndElement;

    /** @var ClientInterface */
    private ClientInterface $client;

    /** @var string */
    private string $queueName;

    /** @var SerializerInterface|null */
    private ?SerializerInterface $serializer;

    /**
     * @param ClientInterface $client
     * @param string $queueName
     * @param SerializerInterface|null $serializer
     */
    public function __construct(ClientInterface $client, string $queueName, ?SerializerInterface $serializer = null)
    {
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
            throw new IllegalStateException('Could not write to redis');
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function offer(Envelope $envelope): bool
    {
        $serialized = $this->serializer->serialize($envelope);

        return (bool) $this->client->rpush(
            $this->queueName,
            [$serialized]
        );
    }

    /**
     * @inheritDoc
     */
    public function poll(): ?Envelope
    {
        try {
            $serialized = $this->client->lpop($this->queueName);
        } catch (\Throwable $e) {
            throw new IllegalStateException('Predis connection error', 0, $e);
        }

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
        $serialized = $this->client->lrange($this->queueName, 0, 0)[0];
        if (empty($serialized)) {
            return null;
        }

        return $this->serializer->deserialize($serialized);
    }
}
