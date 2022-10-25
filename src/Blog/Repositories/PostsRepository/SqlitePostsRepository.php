<?php
namespace App\Blog\Repositories\PostsRepository;
use App\Blog\Post;
use App\Blog\UUID;
use PDO;

class SqlitePostsRepository implements PostsRepositoryInterface
{

    public function __construct(
        private PDO $connection
    ) {
    }
    public function save(Post $post): void
    {
        $statement = $this->connection->prepare('INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:uuid, :author_uuid, :title, :text)'
        );
        $statement->execute([
            ':uuid' => $post->getUuid(),
            ':author_uuid' => $post -> getUser()->uuid(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText(),
        ]);
    }




    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $statement->execute([':uuid'=>(string)$uuid]);
        return  $this->getPost($statement, $uuid);

    }



    public function getPost(\PDOStatement $statement, string $postUuId): Post
    {
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        var_dump($result);
        die();
        return $post;
    }



}