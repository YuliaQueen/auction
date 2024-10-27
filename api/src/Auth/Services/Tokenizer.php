<?php

namespace App\Auth\Services;

use DateInterval;
use DateTimeImmutable;
use App\Auth\Entity\User\ValueObjects\Token;
use Ramsey\Uuid\Uuid;

class Tokenizer
{
    public function __construct(
        private DateInterval $interval,
    )
    {
    }

    public function generate(DateTimeImmutable $expiresAt): Token
    {
        return new Token(Uuid::uuid4()->toString(), $expiresAt->add($this->interval));
    }
}