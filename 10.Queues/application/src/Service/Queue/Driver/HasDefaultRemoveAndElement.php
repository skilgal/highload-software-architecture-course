<?php

declare(strict_types=1);

namespace App\Service\Queue\Driver;

use App\Exception\IllegalStateException;
use App\Exception\NoSuchElementException;
use App\Service\Queue\Envelope;

trait HasDefaultRemoveAndElement
{
    /**
     * Remove and return head of queue, otherwise throwing exception.
     *
     * @return Envelope
     * @throws IllegalStateException | NoSuchElementException
     */
    public function remove(): Envelope
    {
        return $this->returnOrThrowNoSuchElement($this->poll());
    }

    /**
     * Return but do not remove head of queue, otherwise throwing exception.
     *
     * @return Envelope
     * @throws IllegalStateException | NoSuchElementException
     */
    public function element(): Envelope
    {
        return $this->returnOrThrowNoSuchElement($this->peek());
    }

    /**
     * @param Envelope|null $envelope
     *
     * @return Envelope
     * @throws NoSuchElementException
     */
    private function returnOrThrowNoSuchElement(?Envelope $envelope = null): Envelope
    {
        if (!$envelope) {
            throw new NoSuchElementException();
        }

        return $envelope;
    }
}
