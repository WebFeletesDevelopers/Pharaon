<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Application\Service\FindMigrationsInDirectory;

use PHPUnit\Framework\TestCase;
use WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory\FindMigrationsInDirectoryArguments;
use WebFeletesDevelopers\Pharaon\Application\Service\FindMigrationsInDirectory\FindMigrationsInDirectoryService;
use WebFeletesDevelopers\Pharaon\Domain\File\InvalidFileException;
use WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration\MigrationProvider;

/**
 * Class FindMigrationsInDirectoryServiceTest
 * @package WebFeletesDevelopers\Pharaon\Test\Unit\Application\Service\FindMigrationsInDirectory
 * @author WebFeletesDevelopers
 */
class FindMigrationsInDirectoryServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnMigrationsHappyPath(): void
    {
        $path = __DIR__ . '/../../../Assets/migrations';

        $arguments = new FindMigrationsInDirectoryArguments($path);
        $sut = new FindMigrationsInDirectoryService();
        $response = $sut->handle($arguments);

        $testMigrations = MigrationProvider::getTestData();
        [$firstMigration, $secondMigration] = $testMigrations;

        $this->assertTrue($response->success());
        $this->assertEmpty($response->error());
        $this->assertEquals($firstMigration, $response->migrations()[0]);
        $this->assertEquals($secondMigration, $response->migrations()[1]);
    }

    /**
     * @test
     */
    public function itShouldFailBecauseMigrationsFolderDoesNotExist(): void
    {
        $path = __DIR__ . '/iDoNotExist';

        $arguments = new FindMigrationsInDirectoryArguments($path);
        $sut = new FindMigrationsInDirectoryService();
        $response = $sut->handle($arguments);

        $this->assertFalse($response->success());
        $this->assertInstanceOf(InvalidFileException::class, $response->error());
    }

    /**
     * @test
     */
    public function itShouldFailBecauseWeDidNotPassAFolder(): void
    {
        $path = __DIR__ . '/../../../Assets/migrations/20200409153200_down.sql';

        $arguments = new FindMigrationsInDirectoryArguments($path);
        $sut = new FindMigrationsInDirectoryService();
        $response = $sut->handle($arguments);

        $this->assertFalse($response->success());
        $this->assertInstanceOf(InvalidFileException::class, $response->error());
    }

    /**
     * @test
     */
    public function itShouldFailBecauseMigrationsFolderIsEmpty(): void
    {
        $path = __DIR__ . '/../../../Assets/emptymigrations';

        $arguments = new FindMigrationsInDirectoryArguments($path);
        $sut = new FindMigrationsInDirectoryService();
        $response = $sut->handle($arguments);

        $this->assertFalse($response->success());
        $this->assertInstanceOf(InvalidFileException::class, $response->error());
    }
}
