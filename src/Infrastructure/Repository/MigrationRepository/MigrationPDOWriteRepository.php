<?php

namespace WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository;

use Exception;
use WebFeletesDevelopers\Pharaon\Config;
use WebFeletesDevelopers\Pharaon\Domain\File\InvalidFileException;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationWriteRepositoryInterface;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\BasePDORepository;

/**
 * Class MigrationPDOWriteRepository
 * @package WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository
 * @author WebFeletesDevelopers
 */
class MigrationPDOWriteRepository extends BasePDORepository implements MigrationWriteRepositoryInterface
{
    /**
     * @param string $schema
     * @return bool
     */
    public function createMigrationsTable(string $schema): bool
    {
        $query = <<<SQL
        CREATE TABLE ${schema}.migrations(
            id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(80) NOT NULL,
            date_executed DATE NOT NULL
        );

        CREATE UNIQUE INDEX migrations_name ON ${schema}.migrations(name);
SQL;
        $this->connection->exec($query);
        return true;
    }

    /**
     * @param ExecutableMigration $migration
     * @param string $schema
     * @return bool
     * @throws InvalidFileException
     * @throws Exception
     */
    public function executeAndSaveMigration(
        ExecutableMigration $migration,
        string $schema
    ): bool {
        $migrationFile = $migration->migrateFile();
        $migrationQuery = $migrationFile->content();
        $preQuery = <<<SQL
        INSERT INTO ${schema}.migrations(name, date_executed) VALUES (%s, %s);
SQL;
        $date = $migration->migrationDate();
        $query = sprintf($preQuery, $migration->name(), $date->format(Config::MYSQL_DATE_FORMAT));

        $this->connection->beginTransaction();
        try {
            $this->connection->exec($query);
            $this->connection->exec($migrationQuery);
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }

        $this->connection->commit();
        return true;
    }
}
