<?php

namespace App\Blog\Repositories\UsersRepository;

use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Commands\CreateUserCommand;
class DummyUsersRepository implements UsersRepositoryInterface
{

    public function save(User $user): void
    {
        // TODO: Implement save() method.
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(UUID $uuid): User
    {
        throw new UserNotFoundException("Not found");
    }


    /**
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function getByUsername(string|UUID $username): User
    {
        return new User(UUID::random(),  new Name("first", "last"), "user123");
    }
}