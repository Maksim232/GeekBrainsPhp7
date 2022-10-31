<?php
namespace App\Blog\Repositories\PostsRepository;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;
use PDO;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;

class SqlitePostsRepository implements PostsRepositoryInterface
{

    public function __construct(
        private PDO $connection
    ) {
    }
    public function save(Post $post): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:uuid, :author_uuid, :title, :text)'

        );
        $statement->execute([
            ':uuid' => $post->getUuid(),
            ':author_uuid' => $post -> getUser()->uuid(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText(),
        ]);
    }


    /**
     * @throws PostNotFoundException
     * @throws UserNotFoundException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $statement->execute([':uuid'=>(string)$uuid]);
        return  $this->getPost($statement, $uuid);

    }


    /**
     * @throws PostNotFoundException
     * @throws UserNotFoundException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     */
    public function getPost(\PDOStatement $statement, string $postUuId): Post
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new PostNotFoundException(
                "Cannot find user: $postUuId"
            );
        }



        $userRepository = new SqliteUsersRepository($this->connection);
        $user = $userRepository->get(new UUID($result['author_uuid']));


        return new Post(
            new UUID($result['uuid']),
            $user,
            $result['title'],
            $result['text']
        );
    }



}