<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationsTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 5 #1: migrate を実行するとエラーなく完了し、seat_layouts テーブルが存在する */
    public function test_migrate_creates_seat_layouts_table(): void
    {
        $this->assertTrue(Schema::hasTable('seat_layouts'));
    }

    /** Issue 5 #2: migrate 後に classmates テーブルが存在する */
    public function test_migrate_creates_classmates_table(): void
    {
        $this->assertTrue(Schema::hasTable('classmates'));
    }

    /** Issue 5 #3: migrate 後に seat_constraints テーブルが存在する */
    public function test_migrate_creates_seat_constraints_table(): void
    {
        $this->assertTrue(Schema::hasTable('seat_constraints'));
    }

    /** Issue 5 #4: migrate 後に current_seats テーブルが存在する */
    public function test_migrate_creates_current_seats_table(): void
    {
        $this->assertTrue(Schema::hasTable('current_seats'));
    }
}
