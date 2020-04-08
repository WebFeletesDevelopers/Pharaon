<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

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
}
