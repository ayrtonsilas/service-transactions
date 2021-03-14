<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function getAllUsers();
    public function getUserById(int $id);
    public function getUserByFilter(string $email, string $registerCode);
    public function makeUser(array $userData);
    public function updateUser(int $id, array $userData);
    public function canSendValue(int $id);
}
