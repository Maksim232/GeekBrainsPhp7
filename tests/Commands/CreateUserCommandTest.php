<?php

namespace PHPUnit\Commands;

use App\Blog\Commands\Arguments;
use App\Blog\Commands\CreateUserCommand;
use App\Blog\Exceptions\ArgumentsException;
use App\Blog\Exceptions\CommandException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\DummyUsersRepository;

use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use App\Blog\User;
use App\Blog\UUID;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    /**
     * @throws \App\Blog\Exceptions\ArgumentsException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function testItThrowsAnExceptionWhenUserAlreadyExists(): void
    {
// Создаём объект команды
// У команды одна зависимость - UsersRepositoryInterface
        $command = new CreateUserCommand(
new DummyUsersRepository()
        );
// Описываем тип ожидаемого исключения
        $this->expectException(CommandException::class);
        // и его сообщение
        $this->expectExceptionMessage('User already exists: Ivan');
// Запускаем команду с аргументами
        $command->handle(new Arguments(['username' => 'Ivan']));
    }
    private function makeUsersRepository(): UsersRepositoryInterface
    {
        return new class implements UsersRepositoryInterface {
            public function save(User $user): void
            {
            }
            public function get(UUID $uuid): User
            {
                throw new UserNotFoundException("Not found");
            }
            public function getByUsername(string|\App\Blog\UUID $username): User
{
throw new UserNotFoundException("Not found");
}
};
}


    /**
     * @throws CommandException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function testItRequiresFirstName(): void
    {
// $usersRepository - это объект анонимного класса,
// реализующего контракт UsersRepositoryInterface
        $usersRepository = new class implements UsersRepositoryInterface {
            public function save(User $user): void
            {
// Ничего не делаем
            }
            public function get(UUID $uuid): User
            {
// И здесь ничего не делаем
                throw new UserNotFoundException("Not found");
            }
            public function getByUsername(string|\App\Blog\UUID $username): User
            {
// И здесь ничего не делаем
                throw new UserNotFoundException("Not found");
            }
        };
// Передаём объект анонимного класса
// в качестве реализации UsersRepositoryInterface
        $command = new CreateUserCommand($usersRepository);
// Ожидаем, что будет брошено исключение
        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage('No such argument: first_name');
// Запускаем команду
        $command->handle(new Arguments(['username' => 'Ivan']));
    }

    /**
     * @throws ArgumentsException
     * @throws CommandException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function testItSavesUserToRepository(): void
    {
// Создаём объект анонимного класса
        $usersRepository = new class implements UsersRepositoryInterface {
// В этом свойстве мы храним информацию о том,
// был ли вызван метод save
            private bool $called = false;
            public function save(User $user): void
            {
// Запоминаем, что метод save был вызван
                $this->called = true;
            }
            public function get(UUID $uuid): User
            {
                throw new UserNotFoundException("Not found");
            }
            public function getByUsername(string|\App\Blog\UUID $username): User
            {
                throw new UserNotFoundException("Not found");
            }
// Этого метода нет в контракте UsersRepositoryInterface,
// но ничто не мешает его добавить.
// С помощью этого метода мы можем узнать,
// был ли вызван метод save
            public function wasCalled(): bool
            {
                return $this->called;
            }
        };
// Передаём наш мок в команду
        $command = new CreateUserCommand($usersRepository);
// Запускаем команду
        $command->handle(new Arguments([
            'username' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Nikitin',
        ]));
// Проверяем утверждение относительно мока,
// а не утверждение относительно команды
        $this->assertTrue($usersRepository->wasCalled());
    }


}