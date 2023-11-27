<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use App\Traits\DTO;
use Carbon\Cli\Invoker;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;


class MovieDTO implements DTOInterface
{
    use DTO;

    public function __construct(
        private ?int $user_id,
        private ?string $title,
        private ?string $synopsis,
        private ?int $category_id,
        private ?string $duration,
        private ?string $poster,
        private ?string $trailer_link
    ) {
    }

    /**
     * @var StoreUserRequest $request
     */
    public static function makeFromRequest(Request $request, ?int $userId = null): self
    {

        return new self(
            user_id: $request->user() ? $request->user()->id : null,
            title: $request->title ?? null,
            synopsis: $request->synopsis,
            category_id: $request->category_id,
            duration: self::resolveDuration($request->hours, $request->minutes),
            poster: $request->hasFile('poster') ? $request->file('poster')->hashName() : null,
            trailer_link: $request->trailer_link ? self::resolveTrailer($request->trailer_link) : null
        );
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            title: $data['title'],
            synopsis: $data['synopsis'],
            category_id: $data['category_id'],
            duration: $data['duration'],
            poster: $data['poster'],
            trailer_link: $data['trailer_link']
        );
    }

    public static function resolveDuration(string|int $hours, string|int $minutes): string
    {
        return "{$hours}:{$minutes}";
    }

    public static function resolveTrailer(string $trailer_link): string
    {
        $embedCode = mb_substr($trailer_link, 17);
        return "https://www.youtube.com/embed/{$embedCode}";
    }
}
