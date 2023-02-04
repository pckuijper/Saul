<?php

declare(strict_types=1);

namespace Saul\Presentation\Console\Album;

use Exception;
use Saul\Core\Port\MusicLibrary\AlbumDiscoveryServiceInterface;
use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class FindLatestAlbums extends Command
{
    private const DEFAULT_SEARCH_AMOUNT = 25;

    public function __construct(
        private PersistenceServiceInterface $persistenceService,
        private AlbumDiscoveryServiceInterface $albumDiscovery
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('saul:album:find-latest')
            ->setDescription('Find the latest albums')
            ->addOption(
                'amount',
                '-a',
                InputOption::VALUE_OPTIONAL,
                'The amount of albums it will search for',
                self::DEFAULT_SEARCH_AMOUNT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $amountToFind = $this->getAmountInput($input);
        } catch (Exception $e) {
            $output->write($e->getMessage());

            return Command::FAILURE;
        }

        $albums = $this->albumDiscovery->findLatest($amountToFind);

        $output->writeLn('Albums found: ' . count($albums));
        $tableOutput = new Table($output);
        $tableOutput->setHeaders(['Album name', 'Release date', 'Artists', 'Tracks']);

        foreach ($albums as $album) {
            $this->persistenceService->upsert($album);

            $tableOutput->addRow([
                $album->getName(),
                (string) $album->getReleaseDate(),
                implode(
                    ', ',
                    array_map(
                        function ($artist): string {
                            return $artist->getName();
                        }, $album->getArtists()
                    )
                ),
                $album->getTotalTracks(),
            ]);
        }

        $tableOutput->render();

        return Command::SUCCESS;
    }

    private function getAmountInput(InputInterface $input): int
    {
        $amount = $input->getOption('amount');
        if (is_numeric($amount) === false) {
            throw new Exception('Expected amount to be a number, got [' . var_export($amount, true) . '] instead');
        }

        return (int) $amount;
    }
}
