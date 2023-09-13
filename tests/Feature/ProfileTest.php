<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_update_user_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $data = [
            'name' => 'New name',
            'description' => 'New Description',
            'photo' => UploadedFile::fake()->image('test-photo.jpg', 250, 200),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('user.update'), $data);

        $response->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists($user->fresh()->photo);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $data['name'],
            'description' => $data['description'],
            'photo' => $user->fresh()->photo,
        ]);
        $response->assertRedirect(route('profile.index'));
    }

    public function test_update_user_profile_without_photo()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $data = [
            'name' => 'New name',
            'description' => 'New Description',
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('user.update'), $data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $data['name'],
            'description' => $data['description'],
            'photo' => null,
        ]);
        $response->assertRedirect(route('profile.index')); 
    }

    public function test_update_the_user_profile_by_deleting_the_old_photo()
    {
        Storage::fake('public');

        $pathUserImage = Storage::disk('public')
            ->put('photos', UploadedFile::fake()->image('test-image-png'));

        $user = User::factory()->create([
            'photo' => $pathUserImage,
        ]);

        $data = [
            'name' => 'New name',
            'description' => 'New Description',
            'photo' => UploadedFile::fake()->image('test-image.png'),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('user.update'), $data);

            
        $response->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists($user->fresh()->photo);
        Storage::disk('public')->assertMissing($user->photo);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $data['name'],
            'description' => $data['description'],
            'photo' => "photos/{$data['photo']->hashName()}",
        ]);
        $response->assertRedirect(route('profile.index')); 

    }
}
