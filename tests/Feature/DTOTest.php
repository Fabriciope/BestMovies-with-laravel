<?php

namespace Tests\Feature;

use App\DTOs\UserDTO;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DTOTest extends TestCase
{
    public function test_make_user_dto_from_request()
    {
        // Storage::fake('tests');
        $file = UploadedFile::fake()->image('test-image.png', 120, 80);

        $requestData = [
            'name' => 'Fabrício',
            'email' => 'fabricio@gmail.com',
            'password' => 'password',
        ];

        $request = new StoreUserRequest(query: $requestData, files: ['photo' => $file]);

        $userDTO = UserDTO::makeFromRequest($request);
        
        $this->assertInstanceOf(UserDTO::class, $userDTO);

        $arrDTO = $userDTO->toArray();
        $this->assertArrayHasKey('name', $arrDTO);
        $this->assertArrayHasKey('email', $arrDTO);
        $this->assertArrayHasKey('password', $arrDTO);
        $this->assertArrayHasKey('photo', $arrDTO);

        $this->assertEquals($userDTO->email, $requestData['email']);
        $this->assertTrue(Hash::check($requestData['password'], $userDTO->password));

        $this->assertEquals($userDTO->photo, $file->hashName());
    }

    
    public function test_make_user_dto_from_request_without_photo()
    {
        $requestData = [
            'name' => 'Fabrício',
            'email' => 'fabricio@gmail.com',
            'password' => 'password',
        ];

        $request = new StoreUserRequest(query: $requestData);

        $userDTO = UserDTO::makeFromRequest($request);

        $this->assertInstanceOf(UserDTO::class, $userDTO);

        $arrDTO = $userDTO->toArray();
        $this->assertArrayHasKey('name', $arrDTO);
        $this->assertArrayHasKey('email', $arrDTO);
        $this->assertArrayHasKey('password', $arrDTO);
        
        $this->assertEquals($userDTO->name, $requestData['name']);
        $this->assertEquals($userDTO->email, $requestData['email']);
        $this->assertTrue(Hash::check($requestData['password'], $userDTO->password));
        
        $this->assertNull($arrDTO['photo']);
        $this->assertNull($userDTO->photo);
    }
}
