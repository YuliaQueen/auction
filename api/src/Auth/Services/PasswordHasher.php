<?php

namespace App\Auth\Services;

class PasswordHasher
{

    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }
}