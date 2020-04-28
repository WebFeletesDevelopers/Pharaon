<?php

namespace WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory;

use WebFeletesDevelopers\Pharaon\Application\UseCase\BaseUseCaseResponse;
use WebFeletesDevelopers\Pharaon\Domain\Migration\Migration;

/**
 * Class FindMigrationsInDirectoryResponse
 * @package WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory
 * @author WebFeletesDevelopers
 */
class FindMigrationsInDirectoryResponse extends BaseUseCaseResponse
{
    /** @var array<Migration> */
    private array $migrations;

    /**
     * @param array<Migration> $migrations
     */
    public function setMigrations(array $migrations): void
    {
        $this->migrations = $migrations;
    }

    /**
     * @return array<Migration>
     */
    public function migrations(): array
    {
        return $this->migrations;
    }
}
