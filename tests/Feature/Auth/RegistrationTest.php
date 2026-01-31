<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 1 #3 / Issue 3 #1: ゲストが /register で登録フォームが見える（200） */
    public function test_guest_sees_register_form_at_register_route(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** Issue 3 #2: /register のフォームに名前・メール・パスワード・確認パスワード入力がある */
    public function test_register_form_has_name_email_password_fields(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name', false);
        $response->assertSee('email', false);
        $response->assertSee('password', false);
        $response->assertSee('password_confirmation', false);
    }

    /** Issue 1 #4 / Issue 3 #3: 有効なデータで登録するとログイン状態で /home へリダイレクトされる */
    public function test_user_can_register_and_is_redirected_to_home(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    /** Issue 1 #9 / Issue 3 #4: ログイン済みユーザーが /register にアクセスすると /home へリダイレクトされる */
    public function test_logged_in_user_visiting_register_is_redirected_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect(route('home', absolute: false));
    }

    /** Issue 3 #5: 無効なデータで登録するとエラーが表示される */
    public function test_register_with_invalid_data_shows_errors(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }
}
