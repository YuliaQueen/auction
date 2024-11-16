<?php

namespace App\Auth\Entity\User\ValueObjects;

use DateTimeImmutable;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Token
{
    public function __construct(
        private string $value,
        private ?DateTimeImmutable $expiresAt = null,
    )
    {
        Assert::notEmpty($this->value);
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $token
     * @param DateTimeImmutable $confirmationDateTime
     * @return bool
     */
    public function validate(string $token, DateTimeImmutable $confirmationDateTime): bool
    {
        if ($this->value !== $token) {
            throw new InvalidArgumentException('Invalid token');
        }


        if ($this->expiresAt !== null && $confirmationDateTime > $this->expiresAt) {
            throw new InvalidArgumentException('Token has expired');
        }

        return true;
    }
}