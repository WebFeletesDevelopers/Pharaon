<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Table;

/**
 * Class Table
 * @package WebFeletesDevelopers\Pharaon\Domain\Table
 * @author WebFeletesDevelopers
 */
class Table
{
    private const MYSQL_VALID_TABLE_NAMES = '/^[0-9A-z$_]+/';

    /** @var string */
    private string $name;

    /**
     * Table constructor.
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     * @throws InvalidTableNameException
     */
    public static function fromTableName(string $name): self
    {
        self::validateName($name);
        return new self($name);
    }

    /**
     * @param string $name
     * @throws InvalidTableNameException
     */
    private static function validateName(string $name): void
    {
        if (! preg_match(self::MYSQL_VALID_TABLE_NAMES, $name)) {
            throw InvalidTableNameException::fromInvalidName($name);
        }
    }
}
