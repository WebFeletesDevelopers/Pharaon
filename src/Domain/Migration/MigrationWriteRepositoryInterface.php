<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

/**
 * Interface MigrationWriteRepository
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
interface MigrationWriteRepositoryInterface
{
    public function createMigrationsTable(string $schema): bool;
    public function executeAndSaveMigration(ExecutableMigration $migration, string $schema): bool;
}
