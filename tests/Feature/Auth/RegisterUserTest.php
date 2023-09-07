<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    public function test_if_can_register_a_new_user()
    {
        $testEmail = 'fabricioalvespa@gmail.com';
        \App\Models\User::where('email', $testEmail)->delete();

        Event::fake();

        $response = $this->post(route('user.store'), [
            'name' => 'Test6 register user',
            'email' => $testEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['email' => $testEmail]);
        Event::assertDispatched(Registered::class);
        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice'));
    }
}
