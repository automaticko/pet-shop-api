<?php

namespace Tests\Integration\Database\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CreateFilesTableTest extends MigrationsTestCase
{
    const FILENAME   = '2014_10_11_000000_create_files_table.php';
    const TABLE_NAME = 'files';

    /**
     * @test
     * @throws Throwable
     */
    public function it_creates_the_table(): void
    {
        DB::transaction(function() {
            $migration = include $this->migrationFilepath(self::FILENAME);
            $migration->up();

            $this->assertTrue(Schema::hasTable(self::TABLE_NAME));
        });
    }

    /**
     * @test
     * @throws Throwable
     */
    public function it_has_expected_columns(): void
    {
        DB::transaction(function() {
            $migration = include $this->migrationFilepath(self::FILENAME);
            $migration->up();

            $this->assertHasExpectedColumns(self::TABLE_NAME, [
                'id',
                'uuid',
                'name',
                'path',
                'size',
                'type',
                'created_at',
                'updated_at',
            ]);
        });
    }
}
