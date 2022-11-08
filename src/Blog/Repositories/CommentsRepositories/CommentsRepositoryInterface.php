<?php

namespace App\Blog\Repositories\CommentsRepositories;

use App\Blog\Comment;
use App\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function save(Comment $Post): void;
    public function get(UUID $uuid): Comment;
}