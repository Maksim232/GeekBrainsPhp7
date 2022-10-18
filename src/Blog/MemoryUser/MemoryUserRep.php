<?php
namespace App\Blog\MemoryUser;
use App\Blog\User;

class MemoryUserRep
{

    private array $users = [];


    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundExp
     */
    public function get(int $id): User
    {
        foreach ($this->users as $user) {
            if ($user->id() === $id) {
                return $user;
            }
        }
        throw new UserNotFoundExp("User not Found: $id");
    }

}