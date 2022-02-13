<?php

declare(strict_types=1);

namespace App\Service\Queue\Serializer;

use App\Service\Queue\Envelope;

/**
 * Interface SerializerInterface
 */
interface SerializerInterface
{
    /**
     * Serialize data.
     *
     * @param Envelope $envelope
     *
     * @return string
     */
    public function serialize(Envelope $envelope): string;

    /**
     * Unserialize data.
     *
     * @param string $data
     *
     * @return Envelope
     */
    public function deserialize(string $data): Envelope;
}
