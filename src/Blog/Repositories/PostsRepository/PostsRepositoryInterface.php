<?php
namespace App\Blog\Repositories\PostsRepository;
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;

interface PostsRepositoryInterface
{
    public function save(Post $Post): void;
    public function get(UUID $uuid): Post;

}