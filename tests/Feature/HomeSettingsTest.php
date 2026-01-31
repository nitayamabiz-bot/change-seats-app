<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 4 #2: 認証済みユーザーが /settings にアクセスできる（200） */
    public function test_authenticated_user_can_access_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/settings');

        $response->assertStatus(200);
    }

    /** Issue 4 #3: /home で共通レイアウト（ヘッダー・ナビ・ログアウト）が表示される */
    public function test_home_page_uses_common_layout_with_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSee('Log Out', false);
    }

    /** Issue 4 #4: /settings で共通レイアウトが表示される */
    public function test_settings_page_uses_common_layout_with_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/settings');

        $response->assertStatus(200);
        $response->assertSee('Log Out', false);
    }

    /** Issue 4 #5: ゲストが /settings にアクセスするとログインへリダイレクトされる */
    public function test_guest_visiting_settings_is_redirected_to_login(): void
    {
        $response = $this->get('/settings');

        $response->assertRedirect('/login');
    }
}
