<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\User\Service\UserGenerator;
use App\Service\Queue\Envelope;
use App\Service\QueueFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class WriteAction
{
    /** @var QueueFacade */
    private QueueFacade $queueFacade;

    /** @var UserGenerator */
    private UserGenerator $userGenerator;

    /**
     * Constructor.
     *
     * @param QueueFacade $queueFacade
     * @param UserGenerator $userGenerator
     */
    public function __construct(
        QueueFacade $queueFacade,
        UserGenerator $userGenerator
    ) {
        $this->queueFacade = $queueFacade;
        $this->userGenerator = $userGenerator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        try {
            $status = 201;
            $processor = $this->queueFacade->getProcessor($args['queue'] ?? '');
            $envelope = new Envelope($this->userGenerator->createUser()->toString());
            $result = [
                'queue' => $args['queue'] ?? '',
                'action' => 'write',
                'created_message' => $processor->offer($envelope)
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
