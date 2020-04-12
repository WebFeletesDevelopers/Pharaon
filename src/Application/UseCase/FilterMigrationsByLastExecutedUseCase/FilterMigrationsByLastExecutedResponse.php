<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase;

use WebFeletesDevelopers\Pharaon\Application\UseCase\BaseUseCaseResponse;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;

/**
 * Class FilterMigrationsByLastExecutedResponse
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase
 * @author WebFeletesDevelopers
 */
class FilterMigrationsByLastExecutedResponse extends BaseUseCaseResponse
{
    /** @var ExecutableMigration[] array */
    private array $migrations;

    /**
     * @param array<int, ExecutableMigration> $migrations
     */
    public function setMigrations(ExecutableMigration ...$migrations): void
    {
        $this->migrations = $migrations;
    }

    /**
     * @return ExecutableMigration[]
     */
    public function migrations(): array
    {
        return $this->migrations;
    }
}
