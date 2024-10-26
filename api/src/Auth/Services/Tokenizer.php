<?php

namespace App\Auth\Services;

use DateTimeImmutable;
use App\Auth\Entity\User\ValueObjects\Token;

class Tokenizer
{
    public function generate(DateTimeImmutable $now): Token
    {
        return new Token('');
    }
}