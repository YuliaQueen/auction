<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;

/**
 *
 */
class User
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private string $hash;
    private ?Token $joinConfirmToken;

    /**
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Email $email
     * @param string $hash
     * @param Token $token
     */
    public function __construct(Id $id, DateTimeImmutable $date, Email $email, string $hash, Token $token)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->hash = $hash;
        $this->joinConfirmToken = $token;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return Token|null
     */
    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }
}
