<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Service\QueueFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ReadAction
{
    /** @var QueueFacade */
    private QueueFacade $queueFacade;

    /**
     * Constructor.
     *
     * @param QueueFacade $queueFacade
     */
    public function __construct(QueueFacade $queueFacade)
    {
        $this->queueFacade = $queueFacade;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        try {
            $status = 201;
            $processor = $this->queueFacade->getProcessor($args['queue'] ?? '');
            $envelope = $processor->poll();
            $result = [
                'queue' => $args['queue'] ?? '',
                'action' => 'read',
                'read_message' => json_encode($envelope ? $envelope->toArray() : [])
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
