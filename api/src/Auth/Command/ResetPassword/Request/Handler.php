<?php

namespace App\Auth\Command\ResetPassword\Request;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Flusher;
use App\Auth\Service\PasswordResetTokenSender;
use App\Auth\Service\Tokenizer;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private PasswordResetTokenSender $sender;

    /**
     * @param UserRepository $users
     * @param Tokenizer $tokenizer
     * @param Flusher $flusher
     * @param PasswordResetTokenSender $sender
     */
    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        Flusher $flusher,
        PasswordResetTokenSender $sender
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        $user = $this->users->getByEmail($email);

        $date = new \DateTimeImmutable();

        $token = $this->tokenizer->generate($date);

        $user->requestPasswordReset(
            $token = $this->tokenizer->generate($date),
            $date
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
