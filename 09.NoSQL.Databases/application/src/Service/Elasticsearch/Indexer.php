<?php

declare(strict_types=1);

namespace App\Service\Elasticsearch;

use Elasticsearch\Client;

final class Indexer
{
    private const DEFAULT_INDEX_NAME = 'vocabulary';
    private const FILE_NAME = 'dictionary_compact.json';

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

    public function execute(): void
    {
        $this->dropIndex();
        $params = [
            'index' => $this->indexName,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    'properties' => [
                        'word' => [
                            'type' => 'completion'
                        ],
                        'explanation' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ];
        $this->createIndex($params);
        $dictionaryFilePath = file_get_contents(
            sprintf(
                '%s/data/%s',
                dirname(__DIR__, 3),
                self::FILE_NAME
            )
        );
        $dictionary = json_decode($dictionaryFilePath, true);
        $params = [
            'body' => [],
            'index' => $this->indexName,
            'client' => [
                'future' => 'lazy'
            ]
        ];
        $index = 1;
        $lastIndex = 1;
        foreach ($dictionary as $word => $explanation) {
            $params['body'][] = [
                'index' => [
                    '_id' => $index,
                ]
            ];
            $params['body'][] = [
                'word' => $word,
                'explanation' => $explanation
            ];
            if ($index % 5000 === 0) {
                $this->bulkIndex($params, $index);
                $lastIndex = $index;
                $params['body'] = [];
            }
            $index++;
        }

        if (!empty($params['body'])) {
            $this->bulkIndex($params, $lastIndex);
        }
    }

    /**
     * @param array $params
     *
     * @return void
     */
    private function createIndex(array $params): void
    {
        try {
            if ($this->elasticsearchClient->indices()->exists(['index' => $this->indexName])){
                return;
            }
            $this->elasticsearchClient->indices()->create($params);
            printf("Index %s was created successfully\n", $this->indexName);
        } catch (\Exception $exception) {
            printf(
                "Error: index %s cannot be created\n",
                $this->indexName
            );
            printf("%s\n", $exception->getMessage());
            exit(1);
        }
    }

    /**
     * @return void
     */
    private function dropIndex(): void
    {
        try {
            if (!$this->elasticsearchClient->indices()->exists(['index' => $this->indexName])){
                return;
            }
            $this->elasticsearchClient->indices()->delete(['index' => $this->indexName]);
            printf("Index %s was deleted successfully\n", $this->indexName);
        } catch (\Exception $exception) {
            printf(
                "Error: index %s cannot be deleted\n",
                $this->indexName
            );
            printf("%s\n", $exception->getMessage());
            exit(1);
        }
    }

    /**
     * @param array $params
     * @param int $documentsIndexed
     *
     * @return void
     */
    private function bulkIndex(array $params, int $documentsIndexed = 0): void
    {
        try {
            $this->elasticsearchClient->bulk($params);
            printf("Indexed %d documents\n", $documentsIndexed);
        } catch (\Exception $exception) {
            printf(
                'Error: failed to bulk data with _id from %d to %d\n',
                $documentsIndexed-5000,
                $documentsIndexed
            );
            printf("%s\n", $exception->getMessage());
            exit(1);
        }
    }
}
