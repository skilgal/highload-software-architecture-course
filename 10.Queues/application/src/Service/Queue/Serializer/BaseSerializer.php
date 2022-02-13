<?php

declare(strict_types=1);

namespace App\Service\Queue\Serializer;

use App\Service\Queue\Envelope;

/**
 * Class BaseSerializer
 */
final class BaseSerializer implements SerializerInterface
{
    /**
     * @inheritDoc
     */
    public function serialize(Envelope $envelope): string
    {
        return json_encode($envelope->toArray());
    }

    /**
     * @inheritDoc
     */
    public function deserialize(string $data): Envelope
    {
        $rawData = json_decode($data, true);
        if (empty($rawData)) {
            return new Envelope('empty');
        }

        $datetime = new \DateTime();
        $datetime->setTimestamp($rawData['timestamp']);

        return new Envelope($rawData['payload'], $rawData['title'], $datetime);
    }
}
