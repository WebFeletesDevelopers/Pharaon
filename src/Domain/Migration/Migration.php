<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use DateTimeImmutable;
use Exception;

/**
 * Class Migration
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
class Migration
{
    protected DateTimeImmutable $migrationDate;

    /**
     * Migration constructor.
     * @param DateTimeImmutable $migrationDate
     */
    public function __construct(DateTimeImmutable $migrationDate)
    {
        $this->migrationDate = $migrationDate;
    }


    /**
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function migrationDate(): DateTimeImmutable
    {
        return $this->migrationDate;
    }
}
