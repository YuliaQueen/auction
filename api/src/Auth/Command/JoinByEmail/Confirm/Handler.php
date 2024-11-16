<?php

namespace App\Auth\Command\JoinByEmail\Confirm;

use App\Auth\Repositories\UserRepositoryInterface;
use App\Auth\Services\FlusherInterface;
use DateTimeImmutable;
use DomainException;

class Handler
{

    /**
     * @param UserRepositoryInterface $userRepository
     * @param FlusherInterface $flusher
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private FlusherInterface $flusher,
    )
    {
    }

    /**
     * @param Command $command
     * @return void
     */
    public function handle(Command $command): void
    {
        if (!$user = $this->userRepository->findByConfirmToken($command->token)) {
            throw new DomainException('Confirm token is invalid.');
        }

        $user->confirmJoin($command->token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}