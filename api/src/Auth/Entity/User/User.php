<?php

namespace App\Auth\Entity\User;

use App\Auth\Entity\User\ValueObjects\Status;
use DateTimeImmutable;
use App\Auth\Entity\User\ValueObjects\Id;
use App\Auth\Entity\User\ValueObjects\Email;
use App\Auth\Entity\User\ValueObjects\Token;

class User
{
    public function __construct(
        private Id                $id,
        private Email             $email,
        private string            $hash,
        private ?Token            $joinConfirmToken,
        private DateTimeImmutable $createdAt,
        private ?Status           $status = null,
    )
    {
        $this->status = $status ?? Status::wait();
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getId(): ?string
    {
        return $this->id->getValue();
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getJoinConfirmToken(): Token
    {
        return $this->joinConfirmToken;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param string $token
     * @param DateTimeImmutable $confirmationDateTime
     * @return void
     */
    public function confirmJoin(string $token, DateTimeImmutable $confirmationDateTime): void
    {
        if ($this->joinConfirmToken === null) {
            throw new \DomainException('Confirm token is not set.');
        }

        $this->joinConfirmToken->validate($token, $confirmationDateTime);
        $this->status = Status::active();
        $this->joinConfirmToken = null;
    }
}