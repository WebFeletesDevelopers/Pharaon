<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Connection;

/**
 * Interface ConnectionInterface
 * @package WebFeletesDevelopers\Pharaon\Domain\Connection
 * @author WebFeletesDevelopers
 */
interface ConnectionInterface
{
    public function query(string $query): bool;
}
