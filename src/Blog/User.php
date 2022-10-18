<?php

namespace App\Blog;
use App\Person\Name;


class User
{
    public function __construct(
        private Name $username,
        private int $id,
        private  string $login
    ) {
    }
    public function __toString()
    {
        return ' Пользователь ' . $this->id .
            '  с именем ' . $this->username . 'и логином '. $this->login .PHP_EOL;
    }
}

