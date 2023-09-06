<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;

class UserDTO implements DTOInterface
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password,
        public ?string $photo = null
    ){}

    /**
     * @var StoreUserRequest $request
     */
    public static function makeFromRequest(Request $request): self
    {
        return new self(
            id: $request->get('id') ?? null,
            name: $request->name,
            email: $request->email,
            password: Hash::make($request->password),
            photo: $request->hasFile('photo') ? $request->file('photo')->hashName() : null
        );
    }
    
    public static function makeFromArray(array $data): self
    {
        $pathPhoto = $data['photo'] ?? null;
        if($data['photo'] instanceof LengthAwarePaginator || $data['photo'] instanceof File) {
            $pathPhoto = $data['photo']->hashName();
        }
        
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            password: Hash::make($data['password']),
            photo: $pathPhoto
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