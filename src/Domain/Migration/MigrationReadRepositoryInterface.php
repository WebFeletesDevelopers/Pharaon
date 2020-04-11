<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

/**
 * Interface MigrationReadRepository
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
interface MigrationReadRepositoryInterface
{
    public function findLastExecuted(): string;
}
