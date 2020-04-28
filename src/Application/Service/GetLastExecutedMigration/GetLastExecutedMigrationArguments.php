<?php

namespace WebFeletesDevelopers\Pharaon\Application\Service\GetLastExecutedMigration;

use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;

/**
 * Class GetLastExecutedMigrationArguments
 * @package WebFeletesDevelopers\Pharaon\Application\Service\GetLastExecutedMigration
 * @author WebFeletesDevelopers
 */
class GetLastExecutedMigrationArguments
{
    private string $schema;
    /** @var ExecutableMigration[] */
    private array $migrations;

    /**
     * FilterMigrationsByLastExecutedArguments constructor.
     * @param string $schema
     * @param array<int, ExecutableMigration> $migrations
     */
    public function __construct(
        string $schema,
        ExecutableMigration ...$migrations
    ) {
        $this->schema = $schema;
        $this->migrations = $migrations;
    }

    /**
     * @return string
     */
    public function schema(): string
    {
        return $this->schema;
    }

    /**
     * @return ExecutableMigration[]
     */
    public function migrations(): array
    {
        return $this->migrations;
    }
}
