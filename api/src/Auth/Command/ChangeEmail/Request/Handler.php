<?php

namespace App\Auth\Command\ChangeEmail\Request;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Flusher;
use App\Auth\Service\NewEmailConfirmTokenSender;
use App\Auth\Service\Tokenizer;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private NewEmailConfirmTokenSender $sender;

    /**
     * @param UserRepository $users
     * @param Tokenizer $tokenizer
     * @param Flusher $flusher
     * @param NewEmailConfirmTokenSender $sender
     */
    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        Flusher $flusher,
        NewEmailConfirmTokenSender $sender
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('Email is already in use');
        }

        $date = new \DateTimeImmutable();

        $user->requestEmailChanging(
            $token = $this->tokenizer->generate($date),
            $date,
            $email
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }


}
