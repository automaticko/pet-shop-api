<?php

namespace Tests\Integration\Database\Migrations;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Tests\CreatesApplication;
use Tests\TestCase;

abstract class MigrationsTestCase extends TestCase
{
    use CreatesApplication;

    /**
     * @param string $tableName
     * @param array<int, string>  $expectedColumns
     *
     * @return void
     */
    public function assertHasExpectedColumns(string $tableName, array $expectedColumns): void
    {
        $missing = array_diff($expectedColumns, Schema::getColumnListing($tableName));

        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns),
            "Columns missing in table {$tableName}: " . implode(', ', $missing));

        $diff = array_diff(Schema::getColumnListing($tableName), $expectedColumns);

        $this->assertCount(0, $diff, "Columns mismatch in table {$tableName}: " . implode(', ', $diff));
    }

    protected function migrationsPath(): string
    {
        return App::databasePath() . '/migrations';
    }

    protected function migrationFilepath(string $filename): string
    {
        return $this->migrationsPath() . "/{$filename}";
    }
}
