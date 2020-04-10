<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase;

use WebFeletesDevelopers\Pharaon\Application\UseCase\BaseUseCaseResponse;
use WebFeletesDevelopers\Pharaon\Domain\Migration\Migration;

/**
 * Class GetAllMigrationsInDirectoryResponse
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase
 * @author WebFeletesDevelopers
 */
class GetAllMigrationsInDirectoryResponse extends BaseUseCaseResponse
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
