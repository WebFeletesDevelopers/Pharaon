<?php

namespace WebFeletesDevelopers\Pharaon\Test\Unit\Application\UseCase\FilterMigrationsByLastExecutedUseCase;

use Mockery\MockInterface;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase\FilterMigrationsByLastExecutedArguments;
use WebFeletesDevelopers\Pharaon\Application\UseCase\FilterMigrationsByLastExecutedUseCase\FilterMigrationsByLastExecutedUseCase;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\FailedQueryException;
use WebFeletesDevelopers\Pharaon\Infrastructure\Repository\MigrationRepository\MigrationPDOReadRepository;
use WebFeletesDevelopers\Pharaon\Test\Unit\Domain\Migration\MigrationProvider;

/**
 * Class FilterMigrationsByLastExecutedUseCaseTest
 * @package WebFeletesDevelopers\Pharaon\Test\Unit\Application\UseCase\FilterMigrationsByLastExecutedUseCase
 * @author WebFeletesDevelopers
 */
class FilterMigrationsByLastExecutedUseCaseTest extends TestCase
{
    private const SCHEMA_NAME = 'dbname';

    /**
     * @test
     */
    public function itShouldFilterMigrationsHappyPath(): void
    {
        $connection = $this->getPDO();
        $readRepository = new MigrationPDOReadRepository($connection);
        $testMigrations = MigrationProvider::getTestData();
        $arguments = new FilterMigrationsByLastExecutedArguments(self::SCHEMA_NAME, ...$testMigrations);

        $sut = new FilterMigrationsByLastExecutedUseCase($readRepository);
        $response = $sut->handle($arguments);
        [$firstMigration, $secondMigration] = $testMigrations;

        $this->assertTrue($response->success());
        $this->assertEmpty($response->error());
        $this->assertCount(2, $response->migrations());
        $this->assertSame($firstMigration, $response->migrations()[0]);
        $this->assertSame($secondMigration, $response->migrations()[1]);
    }

    /**
     * @test
     */
    public function itShouldFilterMigrationsWithExecutedMigrationHappyPath(): void
    {
        $connection = $this->getPDO(
            [['mock' => 'mock']],
            [['name' => '20200409153200']]
        );
        $readRepository = new MigrationPDOReadRepository($connection);
        $testMigrations = MigrationProvider::getTestData();
        $arguments = new FilterMigrationsByLastExecutedArguments(self::SCHEMA_NAME, ...$testMigrations);

        $sut = new FilterMigrationsByLastExecutedUseCase($readRepository);
        $response = $sut->handle($arguments);
        $secondMigration = $testMigrations[1];

        $this->assertTrue($response->success());
        $this->assertEmpty($response->error());
        $this->assertCount(1, $response->migrations());
        $this->assertSame($secondMigration, $response->migrations()[0]);
    }

    /**
     * @test
     */
    public function itShouldFilterMigrationsWithoutMigrationsTableHappyPath(): void
    {
        $connection = $this->getPDO([]);
        $readRepository = new MigrationPDOReadRepository($connection);
        $testMigrations = MigrationProvider::getTestData();
        $arguments = new FilterMigrationsByLastExecutedArguments(self::SCHEMA_NAME, ...$testMigrations);

        $sut = new FilterMigrationsByLastExecutedUseCase($readRepository);
        $response = $sut->handle($arguments);
        [$firstMigration, $secondMigration] = $testMigrations;

        $this->assertTrue($response->success());
        $this->assertEmpty($response->error());
        $this->assertCount(2, $response->migrations());
        $this->assertSame($firstMigration, $response->migrations()[0]);
        $this->assertSame($secondMigration, $response->migrations()[1]);
    }

    /**
     * @test
     */
    public function itShouldFilterMigrationsFailingBecauseNoStatementOnTableCheck(): void
    {
        $connection = m::mock(PDO::class);
        $this->addTableCheckQueryToPDO($connection, false, self::SCHEMA_NAME);

        $readRepository = new MigrationPDOReadRepository($connection);
        $testMigrations = MigrationProvider::getTestData();
        $arguments = new FilterMigrationsByLastExecutedArguments(self::SCHEMA_NAME, ...$testMigrations);

        $sut = new FilterMigrationsByLastExecutedUseCase($readRepository);
        $response = $sut->handle($arguments);
        $message = $response->error() !== null
            ? $response->error()->getMessage()
            : '';

        $this->assertFalse($response->success());
        $this->assertNotEmpty($response->error());
        $this->assertStringContainsString('SHOW TABLES FROM', $message);
        $this->assertInstanceOf(FailedQueryException::class, $response->error());
    }

    /**
     * @test
     */
    public function itShouldFilterMigrationsFailingBecauseNoStatementOnLastMigrationCheck(): void
    {
        $connection = m::mock(PDO::class);
        $this->addTableCheckQueryToPDO($connection, $this->getCheckTableStatement([['mock' => 'mock']]), self::SCHEMA_NAME);
        $this->addLastMigrationQueryToPDO($connection, false, self::SCHEMA_NAME);

        $readRepository = new MigrationPDOReadRepository($connection);
        $testMigrations = MigrationProvider::getTestData();
        $arguments = new FilterMigrationsByLastExecutedArguments(self::SCHEMA_NAME, ...$testMigrations);

        $sut = new FilterMigrationsByLastExecutedUseCase($readRepository);
        $response = $sut->handle($arguments);
        $message = $response->error() !== null
            ? $response->error()->getMessage()
            : '';

        $this->assertFalse($response->success());
        $this->assertNotEmpty($response->error());
        $this->assertStringContainsString('SELECT m.name as name', $message);
        $this->assertInstanceOf(FailedQueryException::class, $response->error());
    }

    /**
     * @param array<int,string[]> $showTablesResponse
     * @param array<int,string[]> $getExecutedMigrationsResponse
     * @return PDO
     */
    private function getPDO(
        array $showTablesResponse = [['mock' => 'mock']],
        array $getExecutedMigrationsResponse = []
    ): PDO {
        $showTablesStatement = $this->getCheckTableStatement($showTablesResponse);
        $getExecutedMigrationsStatement = $this->getLastMigrationStatement($getExecutedMigrationsResponse);

        $pdo = m::mock(PDO::class);
        $this->addTableCheckQueryToPDO($pdo, $showTablesStatement, self::SCHEMA_NAME);
        $this->addLastMigrationQueryToPDO($pdo, $getExecutedMigrationsStatement, self::SCHEMA_NAME);

        return $pdo;
    }

    /**
     * @param MockInterface $pdo
     * @param PDOStatement<array<string,string>>|false $returnData
     * @param string $schema
     */
    private function addTableCheckQueryToPDO(MockInterface $pdo, $returnData, string $schema): void
    {
        $pdo->shouldReceive('query')
            ->with(m::on(static function (string $input) use ($schema) {
                return strpos($input, "SHOW TABLES FROM ${schema}") !== false
                    && strpos($input, "LIKE 'migrations'") !== false;
            }))
            ->once()
            ->andReturn($returnData);
    }

    /**
     * @param array<int,string[]> $showTablesResponse
     * @return PDOStatement<array<string,string>>
     */
    private function getCheckTableStatement(array $showTablesResponse): PDOStatement
    {
        $showTablesStatement = m::mock(PDOStatement::class);
        $showTablesStatement->shouldReceive('fetchAll')->andReturn($showTablesResponse);
        return $showTablesStatement;
    }

    /**
     * @param MockInterface $pdo
     * @param PDOStatement<array<string,string>>|false $returnData
     * @param string $schema
     */
    private function addLastMigrationQueryToPDO(MockInterface $pdo, $returnData, string $schema): void
    {
        $pdo->shouldReceive('query')
            ->with(m::on(static function (string $input) use ($schema) {
                return strpos($input, 'SELECT m.name as name') !== false
                    && strpos($input, "FROM ${schema}.migrations as m") !== false;
            }))
            ->once()
            ->andReturn($returnData);
    }

    /**
     * @param array<int,string[]> $getExecutedMigrationsResponse
     * @return PDOStatement<array<string,string>>
     */
    private function getLastMigrationStatement(array $getExecutedMigrationsResponse): PDOStatement
    {
        $getExecutedMigrationsStatement = m::mock(PDOStatement::class);
        $getExecutedMigrationsStatement->shouldReceive('fetchAll')->andReturn($getExecutedMigrationsResponse);
        return $getExecutedMigrationsStatement;
    }
}
