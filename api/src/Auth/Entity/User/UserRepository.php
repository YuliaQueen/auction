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

    /**
     * @param Email $email
     *
     * @return User
     * @throws DomainException
     */
    public function getByEmail(Email $email): User;

    public function hasByEmail(Email $email): bool;

    public function hasByNetwork(NetworkIdentity $network): bool;

    public function findByConfirmToken(string $token): ?User;
    public function findByNewEmailToken(string $token): ?User;

    public function findByPasswordResetToken(string $token): ?User;

    public function remove(User $user);
}
