<?php

namespace WebFeletesDevelopers\Pharaon\Domain\File;

/**
 * Class File
 * @package WebFeletesDevelopers\Pharaon\Domain\File
 * @author WebFeletesDevelopers
 */
class File
{
    private string $absolutePath;
    private string $content;

    /**
     * File constructor.
     * @param string $absolutePath
     */
    private function __construct(string $absolutePath)
    {
        $this->absolutePath = $absolutePath;
    }

    /**
     * @return string
     */
    public function absolutePath(): string
    {
        return $this->absolutePath;
    }

    /**
     * @param string $path
     * @return self
     * @throws InvalidFileException
     */
    public static function fromRelativePath(string $path): self
    {
        if (! file_exists($path)) {
            throw InvalidFileException::fromNotFoundRelativePath($path);
        }

        $realPath = realpath($path);
        if (! $realPath) {
            throw InvalidFileException::fromErrorParsingPath($path);
        }

        return new File($realPath);
    }

    /**
     * @return string
     * @throws InvalidFileException
     */
    public function content(): string
    {
        if (! $this->content) {
            $this->fillContent();
        }

        return $this->content;
    }

    /**
     * @throws InvalidFileException
     */
    private function fillContent(): void
    {
        $fileContent = file_get_contents($this->absolutePath());
        if (! $fileContent) {
            throw InvalidFileException::fromErrorReadingContent($this->absolutePath());
        }

        $this->content = $fileContent;
    }
}
