<?php

namespace WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository;

use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationReadRepositoryInterface;

/**
 * Class MigrationPDOReadRepository
 * @package WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository
 * @author WebFeletesDevelopers
 */
class MigrationPDOReadRepositoryInterface implements MigrationReadRepositoryInterface
{

    public function findLastExecuted(): string
    {
        // TODO: Implement findLastExecuted() method.
        return '';
    }
}
