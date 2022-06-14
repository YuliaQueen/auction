<?php

namespace App\Auth\Entity\User;

use DomainException;

interface UserRepository
{
    public function add(User $user): void;

    /**
     * @param Id $id
     *
     * @return User
     * @throws DomainException
     */
    public function get(Id $id): User;

    public function hasByEmail(Email $email): bool;

    public function hasByNetwork(NetworkIdentity $network): bool;

    public function findByConfirmToken(string $token): ?User;
}
