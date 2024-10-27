<?php

namespace Test\Unit\Auth\Services;

use App\Auth\Services\Tokenizer;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testGenerate()
    {
        $interval = new DateInterval('PT1H');
        $dateTime = new DateTimeImmutable('+1 day');

        $tokenizer = new Tokenizer($interval);

        $token = $tokenizer->generate($dateTime);

        self::assertEquals($dateTime->add($interval), $token->getExpiresAt());
    }
}
