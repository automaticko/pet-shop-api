<?php

namespace Tests\Integration\Database\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CreateCategoriesTableTest extends MigrationsTestCase
{
    const FILENAME   = '2023_08_21_182932_create_categories_table.php';
    const TABLE_NAME = 'categories';

    /**
     * @test
     * @throws Throwable
     */
    public function it_creates_the_table(): void
    {
        DB::transaction(function () {
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
        DB::transaction(function () {
            $migration = include $this->migrationFilepath(self::FILENAME);
            $migration->up();

            $this->assertHasExpectedColumns(self::TABLE_NAME, [
                'id',
                'uuid',
                'title',
            ]);
        });
    }
}
