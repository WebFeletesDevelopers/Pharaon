<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase;

/**
 * Class GetAllMigrationsInDirectoryArguments
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase
 * @author WebFeletesDevelopers
 */
class GetAllMigrationsInDirectoryArguments
{
    private string $migrationFilesPath;

    /**
     * GetAllMigrationsInDirectoryArguments constructor.
     * @param string $migrationFilesPath
     */
    public function __construct(string $migrationFilesPath)
    {
        $this->migrationFilesPath = $migrationFilesPath;
    }

    /**
     * @return string
     */
    public function migrationFilesPath(): string
    {
        return $this->migrationFilesPath;
    }
}
