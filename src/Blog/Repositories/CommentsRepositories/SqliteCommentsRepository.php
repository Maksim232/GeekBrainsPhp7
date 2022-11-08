<?php

namespace App\Blog\Repositories\CommentsRepositories;

use App\Blog\Comment;
use App\Blog\Exceptions\CommentNotFoundException;
use App\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use App\Blog\UUID;
use PDO;

class SqliteCommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(
        private PDO $connection
    ) {
    }

    public function save(Comment $comment): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text) VALUES (:uuid, :post_uuid, :author_uuid, :text)'

        );
        $statement->execute([
            ':uuid' => $comment->getUuid(),
            ':post_uuid' => $comment->getPost()->getUuid(),
            ':author_uuid' => $comment -> getUser()->uuid(),
            ':text' => $comment->getText(),
        ]);
    }
    public function get(UUID $uuid): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );
        $statement->execute([':uuid'=>(string)$uuid]);
        return  $this->getComment($statement, $uuid);

    }

    /**
     * @throws CommentNotFoundException
     * @throws \App\Blog\Exceptions\InvalidArgumentException
     * @throws \App\Blog\Exceptions\UserNotFoundException
     * @throws \App\Blog\Exceptions\PostNotFoundException
     */
    public function getComment(\PDOStatement $statement, string $postUuId): Comment
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new CommentNotFoundException(
                "Cannot find user: $postUuId"
            );
        }



        $userRepository = new SqliteUsersRepository($this->connection);
        $postsRepository = new SqlitePostsRepository($this->connection);
        $user = $userRepository->get(new UUID($result['author_uuid']));
        $post = $postsRepository->get(new UUID('8d2ad562-9940-44f1-abe4-d07551f2779e'));

        return new Comment(
            new UUID($result['uuid']),
            $post,
            $user,
            $result['text']
        );
    }


}