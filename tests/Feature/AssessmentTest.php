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
        $user = User::factory()->create();
        $movie = Movie::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);
        $data = [
            'comment' => fake()->text(100),
            'rating' => fake()->numberBetween(0, 10),
        ];

        $response = $this->post(route('assessment.store', $movie->id), $data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(
            'assessments', 
            Arr::collapse([$data, 'user_id' => $user->id, 'movie_id' => $movie->id])
        );
    }
}
