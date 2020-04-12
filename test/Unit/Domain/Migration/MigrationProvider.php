<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration;

use Exception;
use WebFeletesDevelopers\Pharaon\Domain\File\File;
use WebFeletesDevelopers\Pharaon\Domain\Migration\ExecutableMigration;
use WebFeletesDevelopers\Pharaon\Test\Unit\Domain\File\FileProvider;

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
     * @return ExecutableMigration
     * @throws Exception
     */
    public static function getOne(
        File $upFile,
        File $downFile
    ): ExecutableMigration {
        return ExecutableMigration::fromUpAndDownFiles($upFile, $downFile);
    }

    /**
     * @return array<int,ExecutableMigration>
     * @throws Exception
     */
    public static function getTestData(): array
    {
        return [
            self::getOne(
                FileProvider::getOneFromPath(__DIR__ . '/../../Assets/migrations/20200409153200_up.sql'),
                FileProvider::getOneFromPath(__DIR__ . '/../../Assets/migrations/20200409153200_down.sql'),
            ),
            self::getOne(
                FileProvider::getOneFromPath(__DIR__ . '/../../Assets/migrations/20200409153217_up.sql'),
                FileProvider::getOneFromPath(__DIR__ . '/../../Assets/migrations/20200409153217_down.sql'),
            )
        ];
    }
}
