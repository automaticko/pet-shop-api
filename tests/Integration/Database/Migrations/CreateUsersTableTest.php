<?php

namespace Tests\Integration\Database\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CreateUsersTableTest extends MigrationsTestCase
{
    const FILENAME   = '2014_10_12_000000_create_users_table.php';
    const TABLE_NAME = 'users';

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
                'avatar_id',
                'uuid',
                'first_name',
                'last_name',
                'is_admin',
                'email',
                'email_verified_at',
                'password',
                'address',
                'phone_number',
                'is_marketing',
                'created_at',
                'updated_at',
                'last_login_at',
            ]);
        });
    }
}
