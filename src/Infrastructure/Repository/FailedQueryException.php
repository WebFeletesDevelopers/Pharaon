<?php

namespace WebFeletesDevelopers\Pharaon\Infrastructure\Repository;

use Exception;

/**
 * Class FailedQueryException
 * @package WebFeletesDevelopers\Pharaon\Infrastructure\Repository
 * @author WebFeletesDevelopers
 */
class FailedQueryException extends Exception
{
    private const EMPTY_STATEMENT_MESSAGE = 'The query %s returned an empty PDOStatement';

    /**
     * @param string $query
     * @return self
     */
    public static function fromEmptyStatement(string $query): self
    {
        return new self(sprintf(self::EMPTY_STATEMENT_MESSAGE, $query));
    }
}
