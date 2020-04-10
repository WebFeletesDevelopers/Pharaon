<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration;

use WebFeletesDevelopers\Pharaon\Domain\File\File;
use WebFeletesDevelopers\Pharaon\Domain\Migration\Migration;

/**
 * Class MigrationProvider
 * @package WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration
 * @author WebFeletesDevelopers
 */
class MigrationProvider
{
    /**
     * @param File $upFile
     * @param File $downFile
     * @return Migration
     */
    public static function getOne(
        File $upFile,
        File $downFile
    ): Migration {
        return new Migration($upFile, $downFile);
    }
}
