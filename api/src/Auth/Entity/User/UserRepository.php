<?php

namespace App\Auth\Entity\User;

interface UserRepository
{
    public function add(User $user);

    public function hasByEmail(Email $email);
}
