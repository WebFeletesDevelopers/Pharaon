<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use DateTimeImmutable;
use Exception;
use WebFeletesDevelopers\Pharaon\Domain\File\File;

/**
 * Class ExecutableMigration
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
class ExecutableMigration extends Migration
{
    private string $name;
    private File $migrateFile;
    private File $undoFile;

    /**
     * Migration constructor.
     * @param string $name
     * @param File $migrateFile
     * @param File $undoFile
     * @param DateTimeImmutable $migrationDate
     */
    private function __construct(
        string $name,
        File $migrateFile,
        File $undoFile,
        DateTimeImmutable $migrationDate
    ) {
        parent::__construct($migrationDate);
        $this->name = $name;
        $this->migrateFile = $migrateFile;
        $this->undoFile = $undoFile;
    }

    /**
     * @param File $migrateFile
     * @param File $undoFile
     * @return self
     * @throws Exception
     */
    public static function fromUpAndDownFiles(
        File $migrateFile,
        File $undoFile
    ): self {
        $migrationName = self::getMigrationNameFromMigrateFile($migrateFile);
        $date = new DateTimeImmutable($migrationName);
        return new self($migrationName, $migrateFile, $undoFile, $date);
    }

    /**
     * @param File $migrateFile
     * @return string
     */
    private static function getMigrationNameFromMigrateFile(File $migrateFile): string
    {
        $fileName = $migrateFile->name();
        return explode('_up', $fileName)[0];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return File
     */
    public function migrateFile(): File
    {
        return $this->migrateFile;
    }

    /**
     * @return File
     */
    public function undoFile(): File
    {
        return $this->undoFile;
    }
}
