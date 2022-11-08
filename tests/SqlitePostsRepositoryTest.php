<?php

namespace PHPUnit;

use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Post;
use App\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use PDO;
use PHPUnit\Framework\TestCase;

class SqlitePostsRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenPostNotFound(): void{

    }
    public function testItSavesPostToDatabase(): void{

        $connectionStub = $this->createStub(PDO::class);
        $statementMock = $this->createMock(\PDOStatement::class);
        $repository = new SqliteUsersRepository($connectionStub);
        $statementMock->method('fetch')->willReturn(new UUID('8d2ad562-9940-44f1-abe4-d07551f2779e'),
            new Name('first_name', 'last_name'),
            'name');
        $connectionStub->method('prepare')->willReturn($statementMock);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot find user: Ivan');
        $repository->getByUsername('Ivan');

        $user = new User(
            new UUID('8d2ad562-9940-44f1-abe4-d07551f2779e'),
            new Name('first_name', 'last_name'),
            'name'
        );
        $repository->save(
            new Post( // Свойства пользователя точно такие,
// как и в описании мока
                new UUID('8d2ad562-9940-44f1-abe4-d07551f2779e'),
               $user,
                'Ivan',
                'Nikitin'
            )
        );


    }
    public function testItGetPostByUuid(): void{
        $connectionStub = $this->createStub(PDO::class);
        $postRepository = new SqlitePostsRepository($connectionStub);
        $post = $postRepository ->get(new UUID('cbc7b92f-6013-47f0-b0e0-6d062c0684fs'));
        $this->assertSame('cbc7b92f-6013-47f0-b0e0-6d062c0684fs', (string)$post-Uuid());
    }
}