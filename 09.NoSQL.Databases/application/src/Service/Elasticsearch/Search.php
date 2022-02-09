<?php

declare(strict_types=1);

namespace App\Service\Elasticsearch;

use Elasticsearch\Client;

final class Search
{
    private const DEFAULT_INDEX_NAME = 'vocabulary';

    private Client $elasticsearchClient;
    private string $indexName;

    /**
     * @param Client $elasticsearchClient
     * @param string $indexName
     */
    public function __construct(
        Client $elasticsearchClient,
        string $indexName = self::DEFAULT_INDEX_NAME
    ) {
        $this->elasticsearchClient = $elasticsearchClient;
        $this->indexName = $indexName;
    }

    public function execute(string $queryValue): array
    {
        $params = [
            'index' => $this->indexName,
            'body'  => [
                'suggest' => [
                    'word-autocomplete' => [
                        'text' => $queryValue,
                        'completion' => [
                            'field' => 'word',
                            'fuzzy' => [
                                'fuzziness' => 1,
                                'min_length' => 7
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->elasticsearchClient->search($params);
    }
}
