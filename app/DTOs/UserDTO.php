<?php

namespace App\DTOs;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\DTOInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class UserDTO implements DTOInterface
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?string $photo = null
    ){}

    public function __get(string $name): mixed
    {
        return $this->{$name} ?? null;
    }

    /**
     * @var StoreUserRequest $request
     */
    public static function makeFromRequest(Request $request, ?int $userId = null): self|false
    {
        if(in_array('', [$request->name, $request->email, $request->password]))
            return false; 

        return new self(
            id: $request->id ?? $userId,
            name: $request->name,
            email: $request->email,
            password: Hash::make($request->password),
            photo: $request->hasFile('photo') ? $request->file('photo')->hashName() : null
        );
    }
    
    public static function makeFromArray(array $data): self|false
    {
        // if(empty($data['name']) || empty($data['email']) || empty($data['password']))
        //     return false;

        $pathPhoto = $data['photo'] ?? null;
        if($pathPhoto instanceof LengthAwarePaginator || $pathPhoto instanceof File) {
            $pathPhoto = $data['photo']->hashName();
        }

        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: isset($data['password']) ? Hash::make($data['password']) : null,
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