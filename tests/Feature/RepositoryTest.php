<?php

namespace Tests\Feature;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    // test --filter=RepositoryTest::test_should_be_get_all_users
    public function test_get_all_users()
    {
        $repository = new UserRepository();

        $users = $repository->getAll();

        $this->assertIsArray($users);
        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
            $this->assertModelExists($user);
        }
    }

    // test --filter=RepositoryTest::test_should_be_get_all_users_with_filter
    public function test_get_all_users_with_filter()
    {
        $repository = new UserRepository();

        $usersWithFilter = $repository->getAll(['id' => 2]);

        $this->assertIsArray($usersWithFilter);
        $this->assertCount(1, $usersWithFilter);
        foreach ($usersWithFilter as $user) {
            $this->assertInstanceOf(User::class, $user);
            $this->assertModelExists($user);
        }
    }

    public function test_get_all_users_with_pagination()
    {
        $repository = new UserRepository();

        $totalPerPage = 3;
        $paginator = $repository->getAllWithPagination($totalPerPage);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $paginator);
        $this->assertCount($totalPerPage, $paginator->items());
    }

    public function test_create_an_user()
    {
        $userDTO = UserDTO::makeFromArray([
            'name'     => fake()->name(),
            'email'    => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'photo'    => UploadedFile::fake()->image('image-test.png'),
        ]);

        $repository = new UserRepository();
        $createdUser = $repository->store($userDTO);

        $this->assertInstanceOf(User::class, $createdUser);
        $this->assertModelExists($createdUser);
        $this->assertDatabaseHas('users', ['name' => $userDTO->name, 'email' => $userDTO->email]);
    }

    // test --filter=RepositoryTest::test_find_one_user
    public function test_find_one_user()
    {
        $repository = new UserRepository();

        $userFound = $repository->findOne(2);

        $this->assertInstanceOf(User::class, $userFound);
    }

    // test --filter=RepositoryTest::test_find_one_user_with_invalid_id
    public function test_find_one_user_with_invalid_id()
    {
        $repository = new UserRepository();

        $userFound = $repository->findOne(10000);

        $this->assertNull($userFound);
    }

    // test --filter=RepositoryTest::test_update_an_user
    public function test_update_an_user()
    {   
        $dto = UserDTO::makeFromArray([
            'id' => 2,
            'name' => 'Test2 update',
            'email' => 'testUpdate@gmail.com',
        ]);

        $repository = new UserRepository();
        $updatedUser = $repository->update($dto);

        $this->assertNotFalse($updatedUser);
        $this->assertModelExists($updatedUser);
        $this->assertEquals($dto->name, $updatedUser->name);
        $this->assertInstanceOf(User::class, $updatedUser);
    }

    public function test_update_an_user_with_invalid_id()
    {
        $dto = UserDTO::makeFromArray([
            'name' => 'Test wrong update',
            'email' => 'testWrongUpdate@gmail.com',
        ]);

        $repository = new UserRepository();
        $updatedUser = $repository->update($dto);

        $this->assertFalse($updatedUser);
    }

    public function test_delete_an_user()
    {
        $repository = new UserRepository();

        $repository->delete(4);

        $this->assertDatabaseMissing('users', [
            'name' => 'Test wrong update',
            'email' => 'testWrongUpdate@gmail.com',
        ]);
    }
}
