<?php

namespace PHPUnit;

use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class SqliteUsersRepositoryTest extends TestCase
{
    /**
     * @throws UserNotFoundException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function testItThrowsAnExceptionWhenUserNotFound(): void
    {
        $connectionMock = $this->createStub(PDO::class);
        $statementStub = $this->createStub(\PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);
        $connectionMock->method('prepare')->willReturn($statementStub);
        $repository = new SqliteUsersRepository($connectionMock);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot find user: Ivan');
        $repository->getByUsername('Ivan');
    }
    public function testItSavesUserToDatabase(): void
    {
// 2. Создаём стаб подключения
        $connectionStub = $this->createStub(PDO::class);
// 4. Создаём мок запроса, возвращаемый стабом подключения
        $statementMock = $this->createMock(PDOStatement::class);
// 5. Описываем ожидаемое взаимодействие
// нашего репозитория с моком запроса
        $statementMock
            ->expects($this->once()) // Ожидаем, что будет вызван один раз
            ->method('execute') // метод execute
            ->with([ // с единственным аргументом - массивом
//                'author_uuid' => 'cbc7b92f-6013-47f0-b0e0-6d062c0684ff',
                ':uuid' => '8d2ad562-9940-44f1-abe4-d07551f2779e',
                ':first_name' => 'Ivan',
                ':last_name' => 'Nikitin',
                ':username' => 'ivan123',
//                'title' => 'title',
//                'text' => 'text'
            ]);
// 3. При вызове метода prepare стаб подключения
// возвращает мок запроса
        $connectionStub->method('prepare')->willReturn($statementMock);
// 1. Передаём в репозиторий стаб подключения
        $repository = new SqliteUsersRepository($connectionStub);
// Вызываем метод сохранения пользователя
        $repository->save(
            new User( // Свойства пользователя точно такие,
// как и в описании мока
                new UUID('8d2ad562-9940-44f1-abe4-d07551f2779e'),
                new Name('Ivan', 'Nikitin'),
                'ivan123'
            )
        );
    }
}
