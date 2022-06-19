<?php

namespace App\Auth\Command\ChangePassword;

use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Flusher;
use App\Auth\Service\PasswordHasher;

class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    /**
     * @param UserRepository $users
     * @param PasswordHasher $hasher
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handler(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->changePassword($this->hasher, $command->current, $command->new);

        $this->flusher->flush();
    }


}
