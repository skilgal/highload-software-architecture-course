<?php

declare(strict_types=1);

namespace App\Service\Queue;

use DateTime;
use Exception;

/**
 * Class Envelope
 */
final class Envelope
{
    /** @var string */
    private string $payload;

    /** @var string */
    private string $title;

    /** @var DateTime */
    private DateTime $timestamp;

    /**
     * @param string $payload
     * @param string|null $title
     * @param DateTime|null $timestamp
     *
     * @throws Exception
     */
    public function __construct(string $payload, ?string $title = null, ?DateTime $timestamp = null)
    {
        $this->payload = $payload;
        $this->title = $title ?: \bin2hex(\random_bytes(7));
        $this->timestamp = $timestamp ?: new DateTime();
    }

    /**
     * @param string $payload
     * @param string|null $title
     * @param DateTime|null $timestamp
     *
     * @return Envelope
     * @throws Exception
     */
    public static function create(string $payload, ?string $title = null, ?DateTime $timestamp = null): Envelope
    {
        return new self($payload, $title, $timestamp);
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'payload' => $this->payload,
            'title' => $this->title,
            'timestamp' => $this->timestamp->getTimestamp(),
        ];
    }
}
