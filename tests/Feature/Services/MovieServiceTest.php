<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreUpdateMovieRequest;
use App\Models\Movie;
use App\Models\User;
use App\Services\MovieService;
use \App\Repositories\MovieRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function Laravel\Prompts\text;

class MovieServiceTest extends TestCase
{
    use WithFaker;

    public function test_create_a_new_movie(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $title = fake()->name();
        $data = [
            'title' => $title,
            'category_id' => 3,
            'hours' => 2,
            'minutes' => 32,
            'synopsis' => fake()->text(20),
            'trailer_link' => 'https://youtu.be/7SaA3HCOc4c?si=M56Zv1unv05Iltre',
        ];

        $filePoster = UploadedFile::fake()->image('moveBanner-test.png');
        $request = new StoreUpdateMovieRequest(
            query: $data,
            files: ['poster' => $filePoster]
        );

        // $service = (new MovieService(new MovieRepository))
        $createdMovie = (new MovieService(new MovieRepository))->create($request);

        $this->assertNotFalse($createdMovie);
        $this->assertInstanceOf(Movie::class, $createdMovie);
        Storage::disk('public')->assertExists($createdMovie->poster);
        $this->assertDatabaseHas('movies', ['title' => $title]);
    }

    public function test_update_movie()
    {
        Storage::fake('public');

        $movie = Movie::factory()
        ->for(User::factory()->create())
        ->create();

        $data = [
            'title' => fake()->unique()->word(),
            'synopsis' => 'test new synopsis',
        ];

        $filePoster = UploadedFile::fake()->image('newPoster-test.png');
        $request = new StoreUpdateMovieRequest(
            query: $data,
            files: ['poster' => $filePoster]
        );

        $updatedMovie = (new MovieService(new MovieRepository))->update($request, $movie->id);

        $this->assertInstanceOf(Movie::class, $updatedMovie);
        $this->assertDatabaseHas('movies', Arr::collapse([$data, 'synopsis' => $movie->synopsis]));
    }
    
    public function test_delete_a_movie()
    {
        $movie = Movie::factory()
            ->for(User::factory()->create())
            ->create();

        $movieService = (new MovieService(new MovieRepository));
        $movieService->delete($movie->id);        
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
