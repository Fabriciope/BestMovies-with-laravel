<?php

namespace Tests\Unit\DTOs;

use App\DTOs\MovieDTO;
use App\Http\Requests\StoreMovieRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

class MovieDTOTest extends TestCase
{
    use WithFaker;

    public function test_make_movie_dto_from_request()
    {
        $requestData = [
            'title' => fake()->word(),
            'synopsis' => fake()->text(20),
            'category_id' => fake()->numberBetween(1, 8),
            'hours' => 2,
            'minutes' => 32,
            'trailer_link' => 'https://youtu.be/OX4AQgnMmTE?si=9E53q6Exbe5sh0Qa'
        ];

        $filePoster =  UploadedFile::fake()->image('test-poster');
        $dto = MovieDTO::makeFromRequest(
            new StoreMovieRequest(
                query: $requestData,
                files: ['poster' => $filePoster]
            )
        );

        foreach (['title', 'synopsis', 'category_id', 'duration', 'trailer_link'] as $key) {
            $this->assertArrayHasKey($key, $dto->toArray(), 'the array does not contain the key');
            switch ($key) {
                case 'duration':
                    $this->assertEquals("2:32", $dto->{$key});
                    break;
                case 'trailer_link':
                    $this->assertEquals(MovieDTO::resolveTrailer($requestData['trailer_link']), $dto->trailer_link);
                    break;
                default:
                    $this->assertEquals($requestData[$key], $dto->{$key});
                    break;
            }
        }
        $this->assertCount(6, $dto->toArray());
    }
}
