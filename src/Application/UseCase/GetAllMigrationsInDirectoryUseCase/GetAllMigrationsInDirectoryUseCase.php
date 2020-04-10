<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase;

use Exception;
use WebFeletesDevelopers\Pharaon\Domain\File\File;
use WebFeletesDevelopers\Pharaon\Domain\File\InvalidFileException;
use WebFeletesDevelopers\Pharaon\Domain\Migration\Migration;

/**
 * Class GetAllMigrationsInDirectoryUseCase
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase
 * @author WebFeletesDevelopers
 */
class GetAllMigrationsInDirectoryUseCase
{
    /**
     * @param GetAllMigrationsInDirectoryArguments $arguments
     * @return GetAllMigrationsInDirectoryResponse
     */
    public function handle(GetAllMigrationsInDirectoryArguments $arguments): GetAllMigrationsInDirectoryResponse
    {
        $response = new GetAllMigrationsInDirectoryResponse();

        try {
            $allMigrations = $this->getAllMigrationFilesFromDirectory($arguments->migrationFilesPath());
            $response->setMigrations($allMigrations);
        } catch (Exception $e) {
            $response->setError($e);
        }


        return $response;
    }

    /**
     * @param string $directory
     * @return array<Migration>
     * @throws InvalidFileException
     */
    private function getAllMigrationFilesFromDirectory(string $directory): array
    {
        $directoryFile = File::fromRelativePath($directory);
        $subFiles = $directoryFile->findFilesInside();
        $orderedSubFiles = $this->filterFilesByUpAndDown($subFiles);
        return $this->convertOrderedFilesToMigrations($orderedSubFiles);
    }

    /**
     * @param array<File> $originalFiles
     * @return array{up:File[], down:File[]}
     */
    private function filterFilesByUpAndDown(array $originalFiles): array
    {
        $upFiles = [];
        $downFiles = [];

        /** @var File $originalFile */
        foreach ($originalFiles as $i => $originalFile) {
            if ($i % 2 !== 0) {
                $upFiles[] = $originalFile;
            } else {
                $downFiles[] = $originalFile;
            }
        }

        return ['up' => $upFiles, 'down' => $downFiles];
    }

    /**
     * @param array{up:File[], down:File[]} $files
     * @return array<Migration>
     */
    private function convertOrderedFilesToMigrations(array $files): array
    {
        $migrations = [];

        $migrationsCount = count($files['up']);
        for ($i = 0; $i < $migrationsCount; $i++) {
            $migrations[] = new Migration($files['up'][$i], $files['down'][$i]);
        }

        return $migrations;
    }
}
