<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** Issue 1 #3: ゲストが /register で登録フォームが見える（200） */
    public function test_guest_sees_register_form_at_register_route(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** Issue 1 #4: 有効なデータで登録するとログイン状態で /home へリダイレクトされる */
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

    /** Issue 1 #9: ログイン済みユーザーが /register にアクセスすると /home へリダイレクトされる */
    public function test_logged_in_user_visiting_register_is_redirected_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect(route('home', absolute: false));
    }
}
