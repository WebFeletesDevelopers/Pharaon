<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use DateTimeImmutable;
use Exception;
use WebFeletesDevelopers\Pharaon\Domain\File\File;

/**
 * Class Migration
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
class Migration
{
    private File $migrateFile;
    private File $undoFile;
    private ?DateTimeImmutable $migrationDate = null;

    /**
     * Migration constructor.
     * @param File $migrateFile
     * @param File $undoFile
     */
    public function __construct(
        File $migrateFile,
        File $undoFile
    ) {
        $this->migrateFile = $migrateFile;
        $this->undoFile = $undoFile;
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

    /**
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function migrationDate(): DateTimeImmutable
    {
        if (! $this->migrationDate) {
            $path = $this->migrateFile()->absolutePath();
            $explodedPath = explode(DIRECTORY_SEPARATOR, $path);
            $fileName = $explodedPath[count($explodedPath) - 1];
            $this->migrationDate = new DateTimeImmutable(explode('_', $fileName)[0]);
        }

        return $this->migrationDate;
    }
}
