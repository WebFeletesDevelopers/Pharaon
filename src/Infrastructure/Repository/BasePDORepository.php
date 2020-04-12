<?php

namespace WebFeletesDevelopers\Pharaon\Infrastructure\Repository;

use PDO;

/**
 * Class PDOBaseRepository
 * @package WebFeletesDevelopers\Pharaon\Infrastructure\Repository
 * @author WebFeletesDevelopers
 */
class BasePDORepository
{
    protected PDO $connection;

    /**
     * BasePDORepository constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}
