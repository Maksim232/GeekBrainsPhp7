<?php

namespace App\Blog;


use Faker\Provider\Person;

class Post
{
    public function __construct(
        private int $id,
        private User $user,
        private string $text
    ) {
    }
/**
 * @return int
 */
 public function id(): int
{
    return $this->id;
}


    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }




/**
 * @return  Person
 */
public function getAuthor(): User
{
    return $this->user ;
}



/**
 * @param User $user
 */
public function setAuthor(User $user): void
{
    $this->user = $user;
}



/**
 * @return  string
 */
public function getText(): string
{
    return $this->text;
}

/**
 * @param string $text
 */
public function setText(string $text): Post
{
    $this->text = $text;
    return $this;
}
}
