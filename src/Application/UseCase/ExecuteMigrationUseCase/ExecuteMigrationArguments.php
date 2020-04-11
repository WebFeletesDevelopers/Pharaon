<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase;

use WebFeletesDevelopers\Pharaon\Domain\Migration\Migration;

/**
 * Class ExecuteMigrationArguments
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase
 * @author WebFeletesDevelopers
 */
class ExecuteMigrationArguments
{
    private Migration $migration;

    /**
     * ExecuteMigrationArguments constructor.
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * @return Migration
     */
    public function migration(): Migration
    {
        return $this->migration;
    }
}
