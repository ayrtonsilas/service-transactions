<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;


class UserRepository implements UserRepositoryInterface
{

    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * Get all Users
     * @return array
     */
    public function getAllUsers()
    {
        return $this->entity->paginate();
    }

    /**
     * Get User by ID
     * @param int $id
     * @return object
     */
    public function getUserById(int $id)
    {
        return $this->entity->find($id);
    }

    /**
     * Get User by email or register_code
     * @param int $id
     * @return object
     */
    public function getUserByFilter(string $email, string $registerCode)
    {
        return $this->entity->where('email', $email)->
            orWhere('register_code', $registerCode)->first();
    }

    /**
     * Create new User
     * @param array $user
     * @return object
     */
    public function createUser(array $user)
    {
        return $this->entity->create($user);
    }

    /**
     * Update exists Users
     * @param object $user
     * @param array $userData
     * @return object
     */
    public function updateUser(object $user, array $userData)
    {
        return $user->update($userData);
    }
}
