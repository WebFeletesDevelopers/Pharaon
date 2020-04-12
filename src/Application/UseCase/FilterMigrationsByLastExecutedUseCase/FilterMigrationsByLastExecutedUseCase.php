<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase;

use Exception;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationReadRepositoryInterface;

/**
 * Class FilterMigrationsByLastExecutedUseCase
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase
 * @author WebFeletesDevelopers
 */
class FilterMigrationsByLastExecutedUseCase
{
    private MigrationReadRepositoryInterface $readRepository;

    /**
     * FilterMigrationsByLastExecutedUseCase constructor.
     * @param MigrationReadRepositoryInterface $readRepository
     */
    public function __construct(MigrationReadRepositoryInterface $readRepository)
    {
        $this->readRepository = $readRepository;
    }

    public function handle(FilterMigrationsByLastExecutedArguments $arguments): FilterMigrationsByLastExecutedResponse
    {
        $response = new FilterMigrationsByLastExecutedResponse();

        try {
            $migrationsTableExists = $this->readRepository->migrationsTableExists($arguments->schema());
            if ($migrationsTableExists) {
                $executedMigrations = $this->readRepository->findAllExecutedMigrations($arguments->schema());
                $newMigrations = $this->getNewMigrations($executedMigrations, ...$arguments->migrations());
                $response->setMigrations(...$newMigrations);
            }

            $response->setMigrations(...$arguments->migrations());
        } catch (Exception $e) {
            $response->setError($e);
        }

        return $response;
    }

    /**
     * @param string[] $executedMigrations
     * @param ExecutableMigration[] $migrations
     * @return ExecutableMigration[]
     */
    private function getNewMigrations(
        array $executedMigrations,
        array $migrations
    ): array {
        $migrationsToExecute = array_filter(
            $migrations,
            static function (ExecutableMigration $migration) use (&$executedMigrations) {
                return ! in_array($migration->name(), $executedMigrations);
            }
        );

        return array_values($migrationsToExecute);
    }
}
