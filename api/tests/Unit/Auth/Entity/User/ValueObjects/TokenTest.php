<?php

namespace Test\Auth\Entity\User\ValueObjects;

use App\Auth\Entity\User\ValueObjects\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testValidateSuccess()
    {
        $tokenValue = 'sample-token-string';
        $token = (new Token($tokenValue, new \DateTimeImmutable('+1 hour')));
        $this->assertTrue($token->validate($tokenValue, new \DateTimeImmutable()));
    }

    public function testValidateFailureWithInvalidTokenValue()
    {
        $tokenValue = 'sample-token-string';
        $invalidTokenValue = 'invalid-token-string';
        $this->expectException(\InvalidArgumentException::class);

        $token = (new Token($tokenValue, new \DateTimeImmutable('+1 hour')));
        $token->validate($invalidTokenValue, new \DateTimeImmutable());
    }

    public function testValidateFailureWithExpiredDate()
    {
        $tokenValue = 'sample-token-string';
        $token = (new Token($tokenValue, new \DateTimeImmutable('-1 second')));
        $this->expectException(\InvalidArgumentException::class);

        $token->validate($tokenValue, new \DateTimeImmutable());
    }
}
