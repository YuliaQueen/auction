<?php

namespace App\Auth\Entity\User\ValueObjects;

use DateTimeImmutable;
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
}