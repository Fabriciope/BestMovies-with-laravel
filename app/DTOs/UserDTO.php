<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use Illuminate\Http\Request;
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
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            password: Hash::make($data['password']),
            photo: isset($data['photo']) ? $data['photo']->hashName() : null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'photo' => $this->photo,
        ];
    }
}