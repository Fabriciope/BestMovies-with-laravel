<?php

namespace Tests\Unit\DTOs;

use App\DTOs\UserDTO;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserDTOTest extends TestCase
{

    //MakeFromRequest

    public function test_make_user_dto_from_request()
    {
        // Storage::fake('tests');
        $file = UploadedFile::fake()->image('test-image.png', 120, 80);

        $requestData = [
            'name' => 'Fabrício',
            'email' => 'fabricio@gmail.com',
            'password' => 'password',
        ];
        $userDTO = UserDTO::makeFromRequest(
            new RegisterUserRequest(query: $requestData, files: ['photo' => $file])
        );

        $this->assertInstanceOf(UserDTO::class, $userDTO);

        foreach (Arr::collapse([array_keys($requestData), ['photo']]) as $key) {
            $this->assertArrayHasKey($key, $userDTO->toArray());

            switch ($key) {
                case 'password':
                    $this->assertTrue(Hash::check($requestData['password'], $userDTO->password));
                    break;
                case 'photo':
                    $this->assertEquals('photos/'.$file->hashName(), $userDTO->photo);
                    break;
                default:
                    $this->assertEquals($requestData[$key], $userDTO->{$key});
                    break;
            }
        }

        $this->assertCount(4, $userDTO->toArray());
    }

    public function test_make_user_dto_from_request_without_photo()
    {
        $requestData = [
            'name' => 'Fabrício',
            'email' => 'fabricio@gmail.com',
            'password' => 'password',
        ];

        $userDTO = UserDTO::makeFromRequest(new RegisterUserRequest(query: $requestData));
        $this->assertInstanceOf(UserDTO::class, $userDTO);

        foreach ($requestData as $key => $value) {
            $this->assertArrayHasKey($key, $userDTO->toArray());

            if ($key == 'password') {
                $this->assertTrue(Hash::check($value, $userDTO->password));
                continue;
            }
            $this->assertEquals($value, $userDTO->$key);
        }

        $this->assertNull($userDTO->photo);
        $this->assertCount(3, $userDTO->toArray());
    }

    //MakeFromArray
    # test --filter=DTOTest::test_make_user_dto_from_array
    public function test_make_user_dto_from_array()
    {
        $data = [
            'name' => 'Fabrício',
            'email' => 'fabricio@gmail.com',
            'password' => 'password',
            'photo' => UploadedFile::fake()->image('test-image.png', 120, 80),
        ];

        $userDTO = UserDTO::makeFromArray($data);
        $this->assertInstanceOf(UserDTO::class, $userDTO);

        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $userDTO->toArray());

            switch ($key) {
                case 'password':
                    $this->assertTrue(Hash::check($data['password'], $userDTO->password));
                    break;
                case 'photo':
                    $this->assertEquals($data['photo']->hashName(), $userDTO->photo);
                    break;
                default:
                    $this->assertEquals($value, $userDTO->{$key});
                    break;
            }
        }

        $this->assertCount(4, $userDTO->toArray());
    }
}
