<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById(int $id);
    public function getUserByFilter(string $email, string $registerCode);
    public function createUser(array $user);
    public function updateUser(object $user, array $userData);
}