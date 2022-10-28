<?php

namespace App\Blog\Repositories\UsersRepository;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Exceptions\InvalidArgumentException;
use PDO;
use PDOStatement;



class SqliteUsersRepository implements UsersRepositoryInterface
{
    public function __construct(
        private PDO $connection
    ) {
    }
    public function save(User $user): void
    {
        $statement = $this->connection->prepare('INSERT INTO users (first_name, last_name, uuid, username) VALUES (:first_name, :last_name, :uuid, :username)
       ON CONFLICT (uuid) DO UPDATE SET
    first_name = :first_name,
    last_name = :last_name');
        $statement->execute([
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last(),
            ':uuid' => (string)$user->uuid(),
            ':username' => $user->username()
        ]);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */



    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = ?'
        );
        $statement->execute([(string)$uuid]);

        return $this->getUser($statement, $uuid);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUsername(string|UUID $username): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE username = :username'
        );
        $statement->execute([
            ':username' => $username,
        ]);
        return $this->getUser($statement, $username);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    private function getUser(PDOStatement $statement, string $username): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new UserNotFoundException(
                "Cannot find user: $username"
            );
        }
        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'],
                $result['last_name']), $result['username'],
        );
    }



}