<?php

namespace WebFeletesDevelopers\Pharaon\Application\Service\GetLastExecutedMigration;

use WebFeletesDevelopers\Pharaon\Application\UseCase\BaseUseCaseResponse;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;

/**
 * Class GetLastExecutedMigrationResponse
 * @package WebFeletesDevelopers\Pharaon\Application\Service\GetLastExecutedMigration
 * @author WebFeletesDevelopers
 */
class GetLastExecutedMigrationResponse extends BaseUseCaseResponse
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
