<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Service\Elasticsearch\Request\ParameterReader;
use App\Service\Elasticsearch\Search;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SearchAction
{
    private ParameterReader $requestParameterReader;
    private Search $search;

    public function __construct(
        ParameterReader $requestParameterReader,
        Search $search
    ) {
        $this->requestParameterReader = $requestParameterReader;
        $this->search = $search;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        try {
            $arg = $request->getQueryParams('q');
            $result = $this->search->execute(implode("|", $arg) ?? '');
        } catch (\Exception $exception) {
            $result = [
                'error_message' => $exception->getMessage(),
                'error_code' => $exception->getCode()
            ];
        }
        $response->getBody()->write((string) json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
