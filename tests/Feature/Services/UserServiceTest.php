<?php

namespace Tests\Feature\Services;

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_should_be_register_a_new_user(): void
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

    public function test_should_be_update_a_user(): void
    {
        Storage::fake();

        $service = new UserService(new UserRepository);

        $user = User::factory()->create();
        $request = new UpdateProfileRequest(query: [
            'name' => "new name",
            'description' => $user->description,
            'photo' => UploadedFile::fake()->image('photo-fake-user.png'),
        ]);
        
        $this->actingAs($user);

        $user = $service->updateProfile($request);

        Storage::disk('public')->assertExists("photos/{$request->photo}");
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('new name', $user->fresh()->name);
    }
}
