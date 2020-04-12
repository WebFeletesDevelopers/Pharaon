<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Application\UseCase\GetAllMigrationsInDirectoryUseCase;

use PHPUnit\Framework\TestCase;
use WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase\GetAllMigrationsInDirectoryArguments;
use WebFeletesDevelopers\Pharaon\Application\UseCase\GetAllMigrationsInDirectoryUseCase\GetAllMigrationsInDirectoryUseCase;
use WebFeletesDevelopers\Pharaon\Domain\File\InvalidFileException;
use WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration\MigrationProvider;

/**
 * Class GetAllMigrationsInDirectoryUseCaseTest
 * @package WebFeletesDevelopers\Pharaon\Test\Unit\Application\UseCase\GetAllMigrationsInDirectoryUseCase
 * @author WebFeletesDevelopers
 */
class GetAllMigrationsInDirectoryUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnMigrationsHappyPath(): void
    {
        $path = __DIR__ . '/../../../Assets/migrations';

        $arguments = new GetAllMigrationsInDirectoryArguments($path);
        $sut = new GetAllMigrationsInDirectoryUseCase();
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

        $arguments = new GetAllMigrationsInDirectoryArguments($path);
        $sut = new GetAllMigrationsInDirectoryUseCase();
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

        $arguments = new GetAllMigrationsInDirectoryArguments($path);
        $sut = new GetAllMigrationsInDirectoryUseCase();
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

        $arguments = new GetAllMigrationsInDirectoryArguments($path);
        $sut = new GetAllMigrationsInDirectoryUseCase();
        $response = $sut->handle($arguments);

        $this->assertFalse($response->success());
        $this->assertInstanceOf(InvalidFileException::class, $response->error());
    }
}
