<?php

namespace WebFeletesDevelopers\Pharaon\Domain\File;

use Exception;

/**
 * Class InvalidFileException
 * @package WebFeletesDevelopers\Pharaon\Domain\File
 * @author WebFeletesDevelopers
 */
class InvalidFileException extends Exception
{
    private const INVALID_RELATIVE_PATH_NOT_FOUND_MESSAGE = 'The file with relative path %s could not be found.';
    private const ERROR_PARSING_PATH_MESSAGE = 'There was an error parsing the path %s.';
    private const ERROR_READING_CONTENT = 'There was an error reading the content from the file with path %s.';
    private const ERROR_NO_DIRECTORY = 'The file with path %s is not a directory.';

    /**
     * @param string $path
     * @return self
     */
    public static function fromNotFoundRelativePath(string $path): self
    {
        return new self(sprintf(self::INVALID_RELATIVE_PATH_NOT_FOUND_MESSAGE, $path));
    }

    /**
     * @param string $path
     * @return self
     */
    public static function fromErrorParsingPath(string $path): self
    {
        return new self(sprintf(self::ERROR_PARSING_PATH_MESSAGE, $path));
    }

    /**
     * @param string $fullPath
     * @return self
     */
    public static function fromErrorReadingContent(string $fullPath): self
    {
        return new self(sprintf(self::ERROR_READING_CONTENT, $fullPath));
    }

    /**
     * @param string $fullPath
     * @return self
     */
    public static function fromErrorNoDirectory(string $fullPath): self
    {
        return new self(sprintf(self::ERROR_NO_DIRECTORY, $fullPath));
    }
}
