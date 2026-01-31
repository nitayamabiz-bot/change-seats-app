<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsSeatLayoutTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 6 #1: 認証済みユーザーが設定画面で座席の行数・列数を送信して保存できる */
    public function test_authenticated_user_can_save_seat_layout_rows_and_cols(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('settings.seat-layout.store'), [
            'rows' => 5,
            'cols' => 6,
        ]);

        $response->assertRedirect(route('settings'));
        $this->assertDatabaseHas('seat_layouts', [
            'user_id' => $user->id,
            'rows' => 5,
            'cols' => 6,
        ]);
    }

    /** Issue 6 #2: 設定画面を表示すると保存済みの行数・列数が表示される */
    public function test_settings_page_displays_saved_rows_and_cols(): void
    {
        $user = User::factory()->create();
        \App\Models\SeatLayout::create([
            'user_id' => $user->id,
            'rows' => 5,
            'cols' => 6,
        ]);

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertStatus(200);
        $response->assertSee('5', false);
        $response->assertSee('6', false);
    }

    /** Issue 6 #3: 認証済みユーザーがクラスメイトの人数を送信して保存できる */
    public function test_authenticated_user_can_save_class_size(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('settings.seat-layout.store'), [
            'rows' => 5,
            'cols' => 6,
            'class_size' => 30,
        ]);

        $response->assertRedirect(route('settings'));
        $this->assertDatabaseHas('seat_layouts', [
            'user_id' => $user->id,
            'class_size' => 30,
        ]);
    }

    /** Issue 6 #4: 設定画面を表示すると保存済みの人数が表示される */
    public function test_settings_page_displays_saved_class_size(): void
    {
        $user = User::factory()->create();
        \App\Models\SeatLayout::create([
            'user_id' => $user->id,
            'rows' => 5,
            'cols' => 6,
            'class_size' => 30,
        ]);

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertStatus(200);
        $response->assertSee('30', false);
    }
}
