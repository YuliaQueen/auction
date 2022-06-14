<?php

namespace App\Auth\Command\JoinByNetwork;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\User;
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

    /**
     * @param Command $command
     *
     * @return void
     */
    public function handle(Command $command): void
    {
        $identity = new NetworkIdentity($command->network, $command->identity);
        $email = new Email($command->email);

        if ($this->users->hasByNetwork($identity)) {
            throw new \DomainException('User with this network already exist');
        }

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User with this email already exist');
        }

        $user = User::joinByNetwork(
            Id::generate(),
            new \DateTimeImmutable(),
            $email,
            $identity
        );

        $this->users->add($user);

        $this->flusher->flush();
    }
}
