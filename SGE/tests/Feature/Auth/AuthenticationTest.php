<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_matricula(): void
    {
        $user = User::factory()->create([
            'matricula' => 'F20260001',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'matricula' => 'F20260001',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_users_can_not_authenticate(): void
    {
        User::factory()->create([
            'matricula' => 'F20260002',
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'matricula' => 'F20260002',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('matricula');
        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'matricula' => 'F20260003',
        ]);

        $this->post('/login', [
            'matricula' => $user->matricula,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
