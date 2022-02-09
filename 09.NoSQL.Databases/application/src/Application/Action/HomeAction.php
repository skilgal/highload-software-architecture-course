<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    private Responder $responder;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->responder->withRedirectFor($response, 'search');
    }
}
