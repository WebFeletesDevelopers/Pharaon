<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\FailedQueryException;

/**
 * Interface MigrationReadRepository
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
interface MigrationReadRepositoryInterface
{
    public function migrationsTableExists(string $schema): bool;

    /**
     * @param string $schema
     * @return string[]
     * @throws MigrationNotFoundException
     * @throws FailedQueryException
     */
    public function findAllExecutedMigrations(string $schema): array;
}
