<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase;

use Exception;
use WebFeletesDevelopers\Pharaon\Domain\Connection\ConnectionInterface;

/**
 * Class ExecuteMigrationUseCase
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase
 * @author WebFeletesDevelopers
 */
class ExecuteMigrationUseCase
{
    private ConnectionInterface $connection;

    /**
     * ExecuteMigrationUseCase constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ExecuteMigrationArguments $arguments
     * @return ExecuteMigrationResponse
     */
    public function handle(ExecuteMigrationArguments $arguments): ExecuteMigrationResponse
    {
        $response = new ExecuteMigrationResponse();

        try {
            $migration = $arguments->migration();
            $upFile = $migration->migrateFile();
            $query = $upFile->content();
            $this->connection->query($query);
        } catch (Exception $e) {
            $response->setError($e);
        }

        return $response;
    }
}
