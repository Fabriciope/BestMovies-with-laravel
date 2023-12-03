<?php

namespace App\DTOs;

use App\Interfaces\DTOInterface;
use App\Traits\DTO;
use Illuminate\Http\Request;

class AssessmentDTO implements DTOInterface
{
    use DTO;

    public function __construct(
        private ?int $id,
        private ?int $user_id,
        private ?int $movie_id,
        private ?string $comment,
        private ?int $rating,
    ){}

    public static function makeFromRequest(Request $request, ?int $id = null, ?int $userId = null): self
    {
        return new self(
            id: $id,
            user_id: $userId ? $userId : $request->user()->id ?? null,
            movie_id: $request->query('movie_id') ?? null,
            comment: $request->comment ?? null,
            rating: $request->rating ?? null,
        );
    }

    public static function makeFromArray(array $data): DTOInterface
    {
        return new self(
            id: $data['id'],
            user_id: $data['user_id'],
            movie_id: $data['movie_id'],
            comment: $data['comment'],
            rating: $data['rating'],
        ); 
    }
}