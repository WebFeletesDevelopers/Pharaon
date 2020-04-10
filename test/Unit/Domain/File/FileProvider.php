<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Domain\File;

use WebFeletesDevelopers\Pharaon\Domain\File\File;
use WebFeletesDevelopers\Pharaon\Domain\File\InvalidFileException;

/**
 * Class FileProvider
 * @package WebFeletesDevelopers\Pharaon\Test\Unit\Domain\File
 * @author WebFeletesDevelopers
 */
class FileProvider
{
    /**
     * @param string $path
     * @return File
     * @throws InvalidFileException
     */
    public static function getOneFromPath(string $path): File
    {
        return File::fromRelativePath($path);
    }
}
