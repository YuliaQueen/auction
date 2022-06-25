<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Confirm;

use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Flusher;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        if (!$user = $this->users->findByNewEmailToken($command->token)) {
            throw new \DomainException('Incorrect token');
        }

        $user->confirmEmailChanging($command->token, new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
