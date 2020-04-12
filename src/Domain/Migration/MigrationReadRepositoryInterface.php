<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

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
     */
    public function findAllExecutedMigrations(string $schema): array;
}
