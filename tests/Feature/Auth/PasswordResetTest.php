<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    # test --filter=PasswordResetTest::test_send_email_for_reset_password
    public function test_send_email_for_reset_password()
    {
        Notification::fake();
        
        $user = \App\Models\User::factory()->create();
        
        $response = $this->post(route('password.email'), ['email' => $user->email]);
        
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email
        ]);
        Notification::assertSentTo($user, ResetPassword::class);
    }
    
    # test --filter=PasswordResetTest::test_reset_password_screen_can_be_rendered
    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();
        
        $user = \App\Models\User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification) {
                $this->get(route('password.reset', $notification->token))
                    ->assertStatus(200);

                return true;
            }
        );
    }
    
    # test --filter=PasswordResetTest::test_update_password
    public function test_update_password()
    {
        Notification::fake();

        $user = \App\Models\User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification) use ($user) {
                $response = $this->post(route('password.store'), [
                    'token' => $notification->token,
                    'email' => $user->email,
                    'password' => 'newPassword',
                    'password_confirmation' => 'newPassword'
                ]);

                $response->assertSessionHasNoErrors();

                $this->assertDatabaseMissing('password_reset_tokens', [
                    'email' => $user->email
                ]);

                $response->assertRedirect(route('login'));

                return true;
            }
        );
    }

    public function test_update_password_with_invalid_email()
    {
        Notification::fake();

        $user = \App\Models\User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo(
            $user, ResetPassword::class,
            function($notification) use ($user) {
                $response = $this->post(route('password.store'), [
                    'token' => $notification->token,
                    'email' => \App\Models\User::find(3)->email,
                    'password' => 'newPassword',
                    'password_confirmation' => 'newPassword',
                ]);

                $response->assertSessionHasErrors('error');
                $this->assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);

                return true;
            }
        );
    }
}
