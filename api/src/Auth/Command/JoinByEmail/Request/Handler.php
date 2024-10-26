<?php

namespace App\Auth\Command\JoinByEmail\Request;

use DomainException;
use DateTimeImmutable;
use App\Auth\Entity\User\User;
use App\Auth\Services\Tokenizer;
use App\Auth\Services\PasswordHasher;
use App\Auth\Entity\User\ValueObjects\Id;
use App\Auth\Entity\User\ValueObjects\Email;
use App\Auth\Repositories\UserRepositoryInterface;

readonly class Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private Tokenizer               $tokenizer,
        private PasswordHasher          $passwordHasher,
    )
    {
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        if ($this->userRepository->hasByEmail($email)) {
            throw new DomainException('User already exists.');
        }

        $now = new DateTimeImmutable();
        $token = $this->tokenizer->generate($now);
        $user = new User(
            id: Id::generate(),
            email: $email,
            hash: $this->passwordHasher->hash($command->password),
            token: $token,
            createdAt: $now
        );

        $this->userRepository->add($user);
    }
}