<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use App\Auth\Entity\User\ValueObjects\Id;
use App\Auth\Entity\User\ValueObjects\Email;
use App\Auth\Entity\User\ValueObjects\Token;

readonly class User
{
    public function __construct(
        private Id                $id,
        private Email             $email,
        private string            $hash,
        private Token             $token,
        private DateTimeImmutable $createdAt,
    )
    {
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

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}