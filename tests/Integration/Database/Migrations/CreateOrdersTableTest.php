<?php

namespace Integration\Database\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\Integration\Database\Migrations\MigrationsTestCase;
use Throwable;

class CreateOrdersTableTest extends MigrationsTestCase
{
    const FILENAME   = '2023_08_21_214711_create_orders_table.php';
    const TABLE_NAME = 'orders';

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
                'payment_id',
                'order_status_id',
                'uuid',
                'products',
                'address',
                'delivery_fee',
                'amount',
                'created_at',
                'updated_at',
                'shipped_at',
            ]);
        });
    }
}
