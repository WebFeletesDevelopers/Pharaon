<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase;

use Exception;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationNotFoundException;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationReadRepositoryInterface;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\FailedQueryException;

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

    /**
     * @param FilterMigrationsByLastExecutedArguments $arguments
     * @return FilterMigrationsByLastExecutedResponse
     */
    public function handle(FilterMigrationsByLastExecutedArguments $arguments): FilterMigrationsByLastExecutedResponse
    {
        $response = new FilterMigrationsByLastExecutedResponse();

        try {
            $migrationsTableExists = $this->readRepository->migrationsTableExists($arguments->schema());
            if ($migrationsTableExists) {
                $executedMigrations = $this->getExecutedMigrations($arguments->schema());
                $newMigrations = $this->getNewMigrations($executedMigrations, ...$arguments->migrations());
                $response->setMigrations(...$newMigrations);
            } else {
                $response->setMigrations(...$arguments->migrations());
            }
        } catch (Exception $e) {
            $response->setError($e);
        }

        return $response;
    }

    /**
     * @param string[] $executedMigrations
     * @param array<int, ExecutableMigration> $migrations
     * @return ExecutableMigration[]
     */
    private function getNewMigrations(
        array $executedMigrations,
        ExecutableMigration ...$migrations
    ): array {
        if (empty($executedMigrations)) {
            return $migrations;
        }

        $migrationsToExecute = array_filter(
            $migrations,
            static function (ExecutableMigration $migration) use (&$executedMigrations) {
                return ! in_array($migration->name(), $executedMigrations);
            }
        );

        return array_values($migrationsToExecute);
    }

    /**
     * @param string $schema
     * @return string[]
     * @throws FailedQueryException
     */
    private function getExecutedMigrations(string $schema): array
    {
        try {
            return $this->readRepository->findAllExecutedMigrations($schema);
        } catch (MigrationNotFoundException $e) {
            return [];
        }
    }
}
