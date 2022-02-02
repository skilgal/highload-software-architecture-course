<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\User\Service\UserGenerator;
use App\Service\RedisCache;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewUserAction
{
    private const DEFAULT_USER_ID = 1;

    /** @var RedisCache */
    private RedisCache $redisCache;

    /** @var UserGenerator */
    private UserGenerator $userGenerator;

    /**
     * Constructor.
     *
     * @param RedisCache $redisCache
     * @param UserGenerator $userGenerator
     */
    public function __construct(
        RedisCache $redisCache,
        UserGenerator $userGenerator
    ) {
        $this->redisCache = $redisCache;
        $this->userGenerator = $userGenerator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        try {
            //Stampede Prevention cache strategy
            $data = $this->redisCache->xFetch(
                'test_user',
                function () {
                    $user = $this->userGenerator->createUser();
                    return $user->toArray();
                },
                60,
                1.0
            );
            $status = 201;
            $result = [
                'data' => $data,
                'redis_cache_info' => $this->redisCache->getMemoryInfo()
            ];
        } catch (\Exception $exception) {
            $result = [
                'error_message' => $exception->getMessage(),
                'error_code' => $exception->getCode()
            ];
            $status = 500;
        }
        $response->getBody()->write((string) json_encode($result, JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
