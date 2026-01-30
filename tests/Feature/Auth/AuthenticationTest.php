<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 1 #1: ゲストが / にアクセスするとログインへリダイレクトされる */
    public function test_guest_visiting_root_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /** Issue 1 #2: ゲストが /login でログインフォームが見える（200） */
    public function test_guest_sees_login_form_at_login_route(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** Issue 1 #5: 有効な認証情報でログインすると /home へリダイレクトされる */
    public function test_user_can_login_and_is_redirected_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    /** Issue 1 #6: ログイン済みユーザーが /home にアクセスできる（200） */
    public function test_logged_in_user_can_access_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
    }

    /** Issue 1 #7: ログアウトするとログイン画面へリダイレクトされる */
    public function test_user_can_logout_and_is_redirected_to_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    /** Issue 1 #8: ログイン済みユーザーが / にアクセスすると /home へリダイレクトされる */
    public function test_logged_in_user_visiting_root_is_redirected_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('home', absolute: false));
    }

    /** Issue 1 #10: ゲストが /home にアクセスするとログインへリダイレクトされる */
    public function test_guest_visiting_home_is_redirected_to_login(): void
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    /** Issue 1 #11: 無効な認証情報でログインするとエラーが表示される */
    public function test_login_with_invalid_credentials_shows_error(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }
}
