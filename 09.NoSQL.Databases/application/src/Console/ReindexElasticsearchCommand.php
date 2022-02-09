<?php

declare(strict_types=1);

namespace App\Console;

use App\Service\Elasticsearch\Indexer;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ReindexElasticsearchCommand extends Command
{
    private Indexer $searchReindex;

    /**
     * @param Indexer $searchReindex
     * @param string|null $name
     */
    public function __construct(
        Indexer $searchReindex,
        string $name = null
    ) {
        parent::__construct($name);
        $this->searchReindex = $searchReindex;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('es:reindex');
        $this->setDescription('Reindex Elasticsearch indices.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $start = microtime(true);
            $this->searchReindex->execute();
            $output->writeln('<info>Reindex job finished successfully.</info>');
            $output->writeln(
                sprintf(
                    '<info>Took %.2f sec and %d MB RAM</info>',
                    microtime(true) - $start,
                    memory_get_usage(true) / 1048576
                )
            );
            return self::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>Reindex job finished with an error.</error>');
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
            return self::FAILURE;
        }
    }
}
