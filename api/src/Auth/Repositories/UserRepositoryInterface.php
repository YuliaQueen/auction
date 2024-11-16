<?php

namespace App\Auth\Repositories;

use App\Auth\Entity\User\User;
use App\Auth\Entity\User\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function add(User $user);

    public function hasByEmail(Email $email): bool;

    public function findByConfirmToken(string $token): ?User;
}