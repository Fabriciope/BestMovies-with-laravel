<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AssessmentTest extends TestCase
{
    public function test_create_new_assessment()
    {
        
        $userMovie = User::factory()->create(['email_verified_at' => fake()->dateTime('now')]);
        $movie = Movie::factory()->create(['user_id' => $userMovie->id]);
        $data = [
            'comment' => fake()->text(100),
            'rating' => fake()->numberBetween(0, 10),
        ];
        
        $user = User::factory()->create(['email_verified_at' => fake()->dateTime('now')]);
        $this->actingAs($user);
        $response = $this->post(route('assessment.store', $movie->id), $data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(
            'assessments', 
            Arr::collapse([$data, 'user_id' => $user->id, 'movie_id' => $movie->id])
        );
    }
}
