<?php

namespace WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory;

/**
 * Class FindMigrationsInDirectoryArguments
 * @package WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory
 * @author WebFeletesDevelopers
 */
class FindMigrationsInDirectoryArguments
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
