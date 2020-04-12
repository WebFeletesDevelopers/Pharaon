<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use Exception;

/**
 * Class MigrationNotFoundException
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
class MigrationNotFoundException extends Exception
{
    private const NOT_FOUND_MESSAGE = 'Migration not found';

    /**
     * @return self
     */
    public static function fromNotFound(): self
    {
        return new self(self::NOT_FOUND_MESSAGE);
    }
}
