<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Table;

use \Exception;

/**
 * Class InvalidTableNameException
 * @package WebFeletesDevelopers\Pharaon\Domain\Table
 * @author WebFeletesDeveloper
 */
class InvalidTableNameException extends Exception
{
    private const INVALID_NAME_MESSAGE = 'The table name %s is invalid.';

    /**
     * @param string $name
     * @return static
     */
    public static function fromInvalidName(string $name): self
    {
        return new self(sprintf(self::INVALID_NAME_MESSAGE, $name));
    }
}
