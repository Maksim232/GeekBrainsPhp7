<?php

namespace App\Blog;
use App\Person\Name;
use App\Blog\UUID;
use App\Blog;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
class User
{
    public function __construct(
        private UUID $uuid,
        private Name $name,
        private string $username,
    ) {
    }


    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setUsername(Name $name): void
    {
        $this->name = $name;
    }

    /**
     * @return UUID
     */
    public function uuid(): UUID
    {
        return $this->uuid;
    }



    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

//    /**
//     * @param string $username
//     */
//    public function username(string $username): void
//    {
//        $this->username = $username;
//    }
    public function __toString()
    {
        return ' Пользователь ' . $this->uuid .
            '  с именем ' . $this->name . 'и логином '. $this->username .PHP_EOL;
    }

}

