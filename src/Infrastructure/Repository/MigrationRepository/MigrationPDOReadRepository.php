<?php

namespace WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository;

use PDO;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationNotFoundException;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationReadRepositoryInterface;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\BasePDORepository;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\FailedQueryException;

/**
 * Class MigrationPDOReadRepository
 * @package WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository
 * @author WebFeletesDevelopers
 */
class MigrationPDOReadRepository extends BasePDORepository implements MigrationReadRepositoryInterface
{
    /**
     * @param string $schema
     * @return bool
     * @throws FailedQueryException
     */
    public function migrationsTableExists(string $schema): bool
    {
        $query = <<<SQL
        SHOW TABLES FROM ${schema}
        LIKE 'migrations'
SQL;
        $statement = $this->connection->query($query);
        if (! $statement) {
            throw FailedQueryException::fromEmptyStatement($query);
        }

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return ! empty($result);
    }

    /**
     * @param string $schema
     * @return string[]
     * @throws MigrationNotFoundException
     * @throws FailedQueryException
     */
    public function findAllExecutedMigrations(string $schema): array
    {
        $query = <<<SQL
        SELECT m.name as name
        FROM ${schema}.migrations as m;
SQL;
        $statement = $this->connection->query($query);
        if (! $statement) {
            throw FailedQueryException::fromEmptyStatement($query);
        }

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw MigrationNotFoundException::fromNotFound();
        }

        return array_map(static function ($row) {
            return $row['name'];
        }, $result);
    }
}
