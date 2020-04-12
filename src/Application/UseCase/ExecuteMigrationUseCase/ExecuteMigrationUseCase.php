<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase;

use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationReadRepositoryInterface;
use WebFeletesDevelopers\Pharaon\Domain\Migration\MigrationWriteRepositoryInterface;

/**
 * Class ExecuteMigrationUseCase
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\ExecuteMigrationUseCase
 * @author WebFeletesDevelopers
 */
class ExecuteMigrationUseCase
{
    private MigrationReadRepositoryInterface $readRepository;
    private MigrationWriteRepositoryInterface $writeRepository;

    /**
     * ExecuteMigrationUseCase constructor.
     * @param MigrationReadRepositoryInterface $readRepository
     * @param MigrationWriteRepositoryInterface $writeRepository
     */
    public function __construct(
        MigrationReadRepositoryInterface $readRepository,
        MigrationWriteRepositoryInterface $writeRepository
    ) {
        $this->readRepository = $readRepository;
        $this->writeRepository = $writeRepository;
    }

    /**
     * @param ExecuteMigrationArguments $arguments
     * @return ExecuteMigrationResponse
     */
    public function handle(ExecuteMigrationArguments $arguments): ExecuteMigrationResponse
    {
        // TODO: WIP
        $response = new ExecuteMigrationResponse();

        return $response;
    }
}
