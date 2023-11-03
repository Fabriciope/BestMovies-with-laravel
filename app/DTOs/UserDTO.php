<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use App\Traits\DTO;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class UserDTO implements DTOInterface
{
    use DTO;

    public function __construct(
        private ?int $id,
        private ?string $name,
        private ?string $email,
        private ?string $password,
        private ?string $photo, 
        private ?string $description
    ){}

    /**
     * @var StoreUserRequest $request
     */
    public static function makeFromRequest(Request $request, ?int $userId = null): self
    {
        return new self(
            id: $request->user_id ?? $userId,
            name: $request->name ?? null,
            email: $request->email ?? null,
            password: Hash::make($request->password),
            photo: $request->hasFile('photo') ? $request->file('photo')->hashName() : null,   
            description: $request->description ?? null
        );
    }
    
    public static function makeFromArray(array $data): self
    {
        $pathPhoto = $data['photo'] ?? null;
        if($pathPhoto instanceof UploadedFile || $pathPhoto instanceof File) {
            $pathPhoto = $data['photo']->hashName();
        }

        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: isset($data['password']) ? Hash::make($data['password']) : null,
            photo: $pathPhoto,
            description: $data['description'] ?? null
        );
    }
}