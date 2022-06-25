<?php

namespace App\Auth\Test\Unit\Entity\User\User\ChangeEmail;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Test\Builder\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken();

        $user->requestEmailChanging($token, $now, $new = new Email('new-email@test.com'));

        self::assertNotNull($user->getNewEmailToken());
        self::assertEquals($new, $user->getNewEmail());
    }

    public function testInvalidToken(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken();

        $user->requestEmailChanging($token, $now, new Email('new-email@test.com'));

        $this->expectExceptionMessage('Incorrect token');
        $user->confirmEmailChanging('invalid', $now);

    }

    public function testExpiredToken(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken();

        $user->requestEmailChanging($token, $now, new Email('new-email@test.com'));

        $this->expectExceptionMessage('Token already expired');
        $user->confirmEmailChanging($token->getValue(), $now->modify('+1 day'));
    }

    public function testNotRequested(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken();

        $this->expectExceptionMessage('Changing is not required');
        $user->confirmEmailChanging($token->getValue(), $now);
    }

    /**
     * @return Token
     */
    private function createToken(): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            new DateTimeImmutable()
        );
    }
}
