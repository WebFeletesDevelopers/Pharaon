<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

/**
 * Interface MigrationInterface
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
interface MigrationInterface
{
    /**
     * @return bool
     */
    public function execute(): bool;

    /**
     * @return bool
     */
    public function undo(): bool;
}
