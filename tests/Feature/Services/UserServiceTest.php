<?php

namespace Tests\Feature\Services;

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_should_be_register_a_new_user()
    {
        Event::fake();

        $service = new UserService(new UserRepository);

        $request = new RegisterUserRequest(query: [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $registeredUser = $service->register($request);

        $this->assertInstanceOf(\App\Models\User::class, $registeredUser);
        $this->assertDatabaseHas('users', ['email' => $request->email]);
        Event::assertDispatched(Registered::class);
    }
}
