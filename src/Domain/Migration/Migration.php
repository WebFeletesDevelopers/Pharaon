<?php

namespace WebFeletesDevelopers\Pharaon\Domain\Migration;

use WebFeletesDevelopers\Pharaon\Domain\Table\Table;

/**
 * Class Migration
 * @package WebFeletesDevelopers\Pharaon\Domain\Migration
 * @author WebFeletesDevelopers
 */
class Migration implements MigrationInterface
{
    private Table $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return bool being true if the migration has been executed successfully.
     */
    public function execute(): bool
    {
        // TODO: Implement execute() method.

        return false;
    }

    /**
     * @return bool being true if the migration has been undone successfully.
     */
    public function undo(): bool
    {
        // TODO: Implement undo() method.

        return false;
    }
}
