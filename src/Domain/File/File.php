<?php

namespace WebFeletesDevelopers\Pharaon\Domain\File;

/**
 * Class File
 * @package WebFeletesDevelopers\Pharaon\Domain\File
 * @author WebFeletesDevelopers
 * @TODO: Create a directory class maybe?
 */
class File
{
    private const INVALID_FILES_NAME = ['.', '..'];

    private string $name;
    private string $absolutePath;
    private string $content;
    private bool $isFolder;

    /**
     * File constructor.
     * @param string $absolutePath
     * @param string $name
     * @param bool $isFolder
     */
    private function __construct(
        string $absolutePath,
        string $name,
        bool $isFolder = false
    ) {
        $this->absolutePath = $absolutePath;
        $this->name = $name;
        $this->isFolder = $isFolder;
    }

    /**
     * @param string $path
     * @return self
     * @throws InvalidFileException
     */
    public static function fromRelativePath(string $path): self
    {
        $realPath = realpath($path);

        if (! $realPath) {
            throw InvalidFileException::fromNotFoundRelativePath($path);
        }

        $fileName = self::findFileName($path);

        return new File($realPath, $fileName, is_dir($realPath));
    }

    /**
     * @param string $path
     * @return string
     */
    private static function findFileName(string $path): string
    {
        $explodedPath = explode(DIRECTORY_SEPARATOR, $path);
        return $explodedPath[count($explodedPath) - 1];
    }

    /**
     * @return string
     */
    public function absolutePath(): string
    {
        return $this->absolutePath;
    }

    /**
     * @return string
     * @throws InvalidFileException
     */
    public function content(): string
    {
        if (! $this->isFolder && ! $this->content) {
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

    /**
     * @return bool
     */
    public function isFolder(): bool
    {
        return $this->isFolder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return array<File>
     * @throws InvalidFileException
     */
    public function findFilesInside(): array
    {
        $files = [];

        if (! $this->isFolder()) {
            throw InvalidFileException::fromErrorNoDirectory($this->absolutePath());
        }

        /** @var array<string> $directoryContent */
        $directoryContent = scandir($this->absolutePath());

        $filesPath = array_diff($directoryContent, self::INVALID_FILES_NAME);

        if (empty($filesPath)) {
            throw InvalidFileException::fromErrorEmptyDirectory($this->absolutePath());
        }

        foreach ($filesPath as $filePath) {
            $files[] = self::fromRelativePath($this->absolutePath() . DIRECTORY_SEPARATOR . $filePath);
        }

        return $files;
    }
}
