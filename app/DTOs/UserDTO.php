<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class UserDTO implements DTOInterface
{
    public function __construct(
        private ?int $id,
        private ?string $name,
        private ?string $email,
        private ?string $password,
        private ?string $photo, 
        private ?string $description
    ){}

    public function __get(string $name): mixed
    {
        return $this->{$name} ?? null;
    }

    public function __set($name, $value): void
    {
        $this->{$name} = $value;
    }

    /**
     * @var StoreUserRequest $request
     */
    public static function makeFromRequest(Request $request, ?int $userId = null): self
    {
        return new self(
            id: $request->user_id ?? $userId,
            name: $request->name,
            email: $request->email,
            password: Hash::make($request->password),
            photo: $request->hasFile('photo') ? 'photos/'.$request->file('photo')->hashName() : null,   
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

    public function toArray(): array
    {
        $data = [];
        foreach(get_class_vars(self::class) as $attribute => $value) {
            if(! is_null($this->{$attribute})){
                $data[$attribute] = $this->{$attribute};
            }
        }
        
        return $data;
    }
}