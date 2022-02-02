<?php

declare(strict_types=1);

namespace App\Service;

use Closure;
use Predis\ClientInterface;

final class RedisCache
{
    /** @var ClientInterface */
    private ClientInterface $redisClient;

    /**
     * @param ClientInterface $redisClient
     */
    public function __construct(ClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    /**
     * Write/read data from redis.
     *
     * @param $key
     * @param Closure $fallback
     * @param $ttl
     * @param float $beta
     *
     * @return mixed
     */
    public function xFetch($key, Closure $fallback, $ttl, float $beta = 1.0): mixed
    {
        if (0 > $beta = $beta ?? 1.0) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument "$beta" provided to "%s::xFetch()" must be a positive number, %f given.',
                    RedisCache::class,
                    $beta)
            );
        }

        [$value, $delta, $expiry] = $this->read($key);
        $isExpired = (time() - $delta * $beta * log(rand())) > $expiry;
        if (!$value || $isExpired) {
            $start = time();
            if ($value) {
                echo 'Probabilistic cache flush', PHP_EOL;
            }
            $value = $fallback($key);
            $delta  = time() - $start;
            $expiry = time() + $ttl;
            $this->write($key, [$value, $delta, $expiry], $ttl);
        }

        return $value;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function read(string $key): mixed
    {
        $value = $this->redisClient->get($key);
        if (!$value) {
            return null;
        }

        return json_decode($value, true);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     *
     * @return void
     */
    public function write(string $key, mixed $value, int $ttl): void
    {
        $value = json_encode($value);
        $this->redisClient->setex($key, $ttl, $value);
    }

    /**
     * @return string
     */
    public function getMemoryInfo(): string
    {
        return sprintf(
            "Redis used memory: %s\r\nRedis keyspace: %s\r\n",
            $this->redisClient->info('memory')['Memory']['used_memory_human'],
            json_encode(array_values($this->redisClient->info('Keyspace'))[0] ?? [])
        );
    }
}
