<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginTest extends TestCase
{
    # test --filter=LoginTest::test_if_users_can_authenticate
    public function test_if_users_can_authenticate()
    {
        $user = User::factory()->create([
            'password' => 'password'
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
        $response->assertSessionHas('success', 'Successful login');
        $response->assertRedirect(route('profile.index'));
    }

    # test --filter=LoginTest::test_if_users_can_not_authenticate_with_invalid_password
    public function test_if_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => 'password'
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors(['error']);
        $response->assertSessionHasInput('email', $user->email);
        $this->assertGuest();
    }
}
