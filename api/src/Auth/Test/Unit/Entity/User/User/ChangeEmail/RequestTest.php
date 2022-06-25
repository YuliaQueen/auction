<?php

namespace App\Auth\Test\Unit\Entity\User\User\ChangeEmail;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())
            ->withEmail($old = new Email('old-email@mail.com'))
            ->active()
            ->build();

        $now = new \DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $user->requestEmailChanging($token, $now, $new = new Email('new-email@mail.com'));

        self::assertNotNull($user->getNewEmailToken());
        self::assertEquals($old, $user->getEmail());
        self::assertEquals($new, $user->getNewEmail());
    }

    public function testSame()
    {
        $user = (new UserBuilder())
            ->withEmail($old = new Email('old-email@mail.com'))
            ->active()
            ->build();

        $now = new \DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $this->expectExceptionMessage('Email is already same');
        $user->requestEmailChanging($token, $now, $old);
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new \DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $user->requestEmailChanging($token, $now, $email = new Email('new-email@mail.com'));

        $this->expectExceptionMessage('Email is already requested');
        $user->requestEmailChanging($token, $now, $email);
    }

    public function testExpired(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new \DateTimeImmutable();
        $token = $this->createToken($now);

        $user->requestEmailChanging($token, $now, new Email('new-email@mail.com'));

        $newDate = $now->modify('+2 hours');
        $newToken = $this->createToken($newDate->modify('+1 hour'));
        $user->requestEmailChanging($newToken, $newDate, $newEmail = new Email('new-email@mail.com'));

        self::assertEquals($newEmail, $user->getNewEmail());
        self::assertEquals($newToken, $user->getNewEmailToken());
    }

    public function testNoActive(): void
    {
        $now = new \DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 day'));

        $user = (new UserBuilder())
            ->build();

        $this->expectExceptionMessage('User is not active');
        $user->requestPasswordReset($token, $now);
    }

    private function createToken(\DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
