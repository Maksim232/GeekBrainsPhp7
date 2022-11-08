<?php

namespace App\Blog\Commands;

use App\Blog\Exceptions\ArgumentsException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\User;
use App\Blog\UUID;
use App\Blog\Exceptions\CommandException;
use App\Person\Name;

class CreateUserCommand
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    ) {
    }

    /**
     * @throws CommandException
     * @throws ArgumentsException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     * @throws \App\Blog\Exceptions\ArgumentsException
     */
    public function handle(Arguments $arguments): void
    {
        $username = $arguments->get('username');
// Проверяем, существует ли пользователь в репозитории
        if ($this->userExists($username)) {
// Бросаем исключение, если пользователь уже существует
            throw new CommandException("User already exists: $username");
        }


        $this->usersRepository->save(new User(
            UUID::random(),
            new Name($arguments->get('first_name'),
                $arguments->get('last_name')),
            $username
        ));
    }

    private function userExists(string $username): bool
    {
        try {
            $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }

}


